<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetCountries()
    {
        $response = $this->get('/api/countries');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Params retrieved successfully',
                'data'    => []
            ]);
    }

    public function testGetCities()
    {
        $response = $this->get('/api/cities/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Params retrieved successfully',
                'data'    => []
            ]);
    }
    public function testGetHistory()
    {
        $response = $this->get('/api/history_show');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'History retrieved successfully',
                'data'    => []
            ]);
    }
    public function testPostCalculator()
    {
        $response = $this->post(
            '/api/calculator',
            [
                'budget' => '20000',
                'city' => '5',
                'country' => '1',
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Information consulted correctly',
                'data'    => []
            ]);
    }
}
