<?php

namespace Warfehr\OmegaOledMsg\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Warfehr\OmegaOledMsg\MsgModel;

class UnitTest extends TestCase
{
    use DatabaseTransactions;

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

        // shared on most tests
        $this->msg_array = [
            'content' => implode('', array_fill(0, 32, 1)),
            'columns' => $this->columns
        ];
    }

    /**
     * Test the accessor
     */
    public function testImgPath()
    {
        $msg_model = new MsgModel(
            array_merge(
                ['author' => 'warfehr test image path'],
                $this->msg_array
            )
        );
        $msg_model->save();

        $this->assertTrue($msg_model->img_path == public_path("images/msg" . $msg_model->id . ".png"));
    }
}
