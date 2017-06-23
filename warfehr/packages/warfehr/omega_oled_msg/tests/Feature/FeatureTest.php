<?php

namespace Warfehr\OmegaOledMsg\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class FeatureTest extends TestCase
{
    private $rows;
    private $columns;
    private $total;

    private function before() 
    {
        $this->rows = config('config.rows');
        $this->columns = config('config.columns');

        $this->total = $this->rows * $this->columns;
    }
    /**
     * Test failure and success
     *
     * @return void
     */
    public function testFailure()
    {
        $response = $this->post('/oled-msg');

        $response->assertSessionHasErrors(['author', 'block']);
    }

    public function testSuccess()
    {
        // don't need to run the events here
        $this->withoutEvents();

        $this->before();

        DB::beginTransaction();
        $response = $this->post('/oled-msg', [
            'author' => 'warfehr test author',
            'block' => array_fill(0, $this->total, 1)
        ]);
        $response->assertSessionHas('warfehr_status', 'Message queued.');
        
        DB::rollBack();
    }

    public function testEventsFired()
    {
        Event::fake();

        $this->before();
        
        DB::beginTransaction();
        $response = $this->post('/oled-msg', [
            'author' => 'warfehr test author',
            'block' => array_fill(0, $this->total, 1)
        ]);

        DB::rollBack();

        Event::assertDispatched('WarfehrMsg');
        Event::assertDispatched('WarfehrImg');
        Event::assertDispatched('WarfehrSocial');
    }

    public function testDatabase()
    {
        $this->before();
        
        DB::beginTransaction();
        $response = $this->post('/oled-msg', [
            'author' => 'warfehr test author in database',
            'block' => array_fill(0, $this->total, 1)
        ]);
        $this->assertDatabaseHas('oled_msg', ['author' => 'warfehr test author in database']);

        DB::rollBack();
    }
}
