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
                'name' => $name,
                'email' => $email,
                'body' => $body,
            ]
        )
        ->assertStatus(201)
        ->assertJson([
            'name' => $name,
            'email' => $email,
            'body' => $body,
        ]);
    }

    public function testGetContacts()
    {
        $this->get(
            '/api/messages',
        )
        ->assertStatus(200)
        ->assertJsonStructure([
                '*' => [
                'name',
                'email',
                'body',
            ],
        ]);
    }

    public function testFilterContacts()
    {

        $name = $this->faker->name;
        $email = $this->faker->email;
        $body = $this->faker->text;

        $this->post(
            '/api/messages',
            [
                'name' => $name,
                'email' => $email,
                'body' => $body,
            ]
        )
        ->assertStatus(201)
        ->assertJson([
            'name' => $name,
            'email' => $email,
            'body' => $body,
        ]);

        $this->get(
            '/api/messages?name=' . $name,
        )
        ->assertStatus(200)
        ->assertJson([
                [
                'name' => $name,
                'email' => $email,
                'body' => $body,
            ]
        ]);

        $this->get(
            '/api/messages?email=' . $email,
        )
        ->assertStatus(200)
        ->assertJson([
                [
                'name' => $name,
                'email' => $email,
                'body' => $body,
            ]
        ]);
    }
}
