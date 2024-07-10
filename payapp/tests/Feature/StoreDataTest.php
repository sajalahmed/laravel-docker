<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreDataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_api_post_request_returns_expected_json(): void
    {
        // Define the JSON data to send with the POST request
        $postData = [
            'name' => 'sajal' // Replace 'key' and 'value' with your actual data
        ];

        // Make a POST request to the endpoint with the JSON data
        $response = $this->postJson('/store', $postData);

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
