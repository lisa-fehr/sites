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
        DB::beginTransaction();
        $response = $this->post('/oled-msg', [
            'author' => 'warfehr test author',
            'block' => [
                0 => 1
            ]
        ]);
        $response->assertSessionHas('warfehr_status', 'Message queued.');
        
        DB::rollBack();
    }

    public function testEventFired()
    {
        Event::fake();

        DB::beginTransaction();
        $response = $this->post('/oled-msg', [
            'author' => 'warfehr test author',
            'block' => [
                0 => 1
            ]
        ]);
        DB::rollBack();

        Event::assertDispatched('WarfehrMsg.creating');
    }
}