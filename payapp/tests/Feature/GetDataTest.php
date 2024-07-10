<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetDataTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $params = [
            'name' => 'sajal' // Replace 'key' and 'value' with your actual parameters
        ];

        // Make a GET request to the endpoint with the parameters
        $response = $this->getJson('/', $params);

        // Assert the status is 200 OK
        $response->assertStatus(200);

        // Assert the response structure and content
        $response->assertJson([
            'data' => [
                ['name' => 'sajal']
            ]
        ]);
    }
}
