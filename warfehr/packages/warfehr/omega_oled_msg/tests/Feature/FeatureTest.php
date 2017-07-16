<?php

namespace Warfehr\OmegaOledMsg\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Thujohn\Twitter\Facades\Twitter;
use Warfehr\OmegaOledMsg\MsgModel;
use Warfehr\OmegaOledMsg\Jobs\ProcessImg;
use Warfehr\OmegaOledMsg\Jobs\ProcessSocial;

class FeatureTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Total digits in the message
     * @var integer
     */
    private $total = 32;

    /**
     * Columns for each row of digits
     * @var integer
     */
    private $columns = 16;

    /**
     * Message array
     * @var array
     */
    private $msg_array = [];

    /**
     * Default preparation for each test
     */
    public function setUp()
    {
        parent::setUp(); 
        Queue::fake();

        // shared on most tests
        $this->msg_array = [
            'block' => array_fill(0, $this->total, 1),
            'columns' => $this->columns
        ];
    }

    public function testFailure()
    {
        $response = $this->post('/oled-msg');

        $response->assertSessionHasErrors(['author', 'content']);
    }

    public function testSuccessMessage()
    {
        $this->msg_array['author'] = 'warfehr test author success';

        $response = $this->post('/oled-msg', $this->msg_array);
        $response->assertSessionHas('warfehr_status', 'Message queued.');
    }

    public function testEventsFired()
    {
        Event::fake();

        $this->msg_array['author'] = 'warfehr test author in events';

        $response = $this->post('/oled-msg', $this->msg_array);

        Event::assertDispatched('WarfehrMsg');
    }

    public function testQueued()
    {
        $this->msg_array['author'] = 'warfehr queue test author in queue';

        $response = $this->post('/oled-msg', $this->msg_array);

        Queue::assertPushed(ProcessImg::class, function ($job) {
            return $job->msg->author === $this->msg_array['author'];
        });
        Queue::assertPushed(ProcessSocial::class, function ($job) {
            return $job->msg->author === $this->msg_array['author'];
        });

        Queue::assertPushedOn('processing_img', ProcessImg::class);
        Queue::assertPushedOn('processing_social', ProcessSocial::class);
    }

    public function testDatabaseSaved()
    {
        $this->msg_array['author'] = 'warfehr test author in database';

        $response = $this->post('/oled-msg', $this->msg_array);
        $this->assertDatabaseHas('oled_msg', ['author' => $this->msg_array['author']]);
    }

    /**
     * Image is required to tweet, so run both image and social jobs
     */
    public function testCreatedAt()
    {
        $this->msg_array['content'] = implode('', $this->msg_array['block']);
        unset($this->msg_array['block']);

        $msg_model = new MsgModel(
            array_merge(
                ['author' => 'warfehr test created at'],
                $this->msg_array
            )
        );
        $msg_model->save();

        (new ProcessImg($msg_model))->handle();
        (new ProcessSocial($msg_model))->handle();
        
        $updated_msg = MsgModel::find($msg_model->id);
        $this->assertNotNull($updated_msg->img_created_at, "Failed to assert image created at");
        $this->assertNotNull($updated_msg->tweet_created_at, "Failed to assert tweet created at");

        // remove the tweet created
        $twitter = Twitter::getUserTimeline(['screen_name' => config('config.twitter-handle'), 'count' => 1]);
        Twitter::destroyTweet($twitter[0]->id);

        // remove the image created
        unlink($msg_model->img_path);

    }
}
