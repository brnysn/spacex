<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CapsuleTest extends TestCase
{
    
    public function testGetAllCapsules()
    {
        $user             = factory(\App\User::class)->create();
        $response         = $this->actingAs($user, 'api')->json('GET', '/api/v1/capsules');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                [
                'capsule_serial', 
                'capsule_id', 
                'status', 
                'original_launch', 
                'original_launch_unix', 
                'landings', 
                'type',
                'details',
                'reuse_count',
                'created_at',
                'updated_at'
                ]
            ]
        );
    }

    public function testCommanFetch()
    {
        
        $this->artisan('fetch:spacex')

        $this->assertTrue(true);

    }
}
