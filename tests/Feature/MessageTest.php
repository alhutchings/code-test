<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class MessageTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateMessage()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $body = $this->faker->text;

        $this->post(
            '/api/messages',
            [
                "user" => [
                    'name' => $name,
                    'email' => $email,
                ],
                'body' => $body,
            ]
        )
        ->assertStatus(201)
        ->assertJsonStructure([
            "user_id",
            'body',
        ]);
    }

    public function testGetMessages()
    {
        $this->get(
            '/api/messages?with=user',
        )
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                "user" => [
                    'name',
                    'email',
                ],
                'body',
            ],
        ]);
    }

    public function testFilterMessages()
    {

        $name = $this->faker->name;
        $email = $this->faker->email;
        $body = $this->faker->text;

        $this->post(
            '/api/messages',
            [
                'user' => [
                    'name' => $name,
                    'email' => $email,
                ],
                'body' => $body,
            ]
        )
        ->assertStatus(201)
        ->assertJsonStructure([
            "user_id",
            'body',
        ]);

        $this->get(
            '/api/messages?user.name=' . $name,
        )
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                'body',
                'user',
            ],
        ]);

        $this->get(
            '/api/messages?user.email=' . $email,
        )
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                'body',
                'user',
            ],
        ]);
    }
}
