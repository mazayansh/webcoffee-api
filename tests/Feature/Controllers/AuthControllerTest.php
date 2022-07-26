<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Traits\DemoDataTestTrait;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, DemoDataTestTrait;

    public function test_register_validation_failed()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'first_name' => 'Imam',
            'last_name' => 'Setiawan',
            'email' => 'simam',
            'password' => '12345',
            'password_confirmation' => '12345678'
        ]);

        $response->assertStatus(422)->assertJson(fn (AssertableJson $json) => 
            $json->hasAny(['message', 'errors'])
        );
    }

    public function test_register_success()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'first_name' => 'Imam',
            'last_name' => 'Setiawan',
            'email' => 'simam@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertStatus(201)->assertJson(fn (AssertableJson $json) => 
            $json->hasAll(['message', 'user'])
                ->where('user.email', 'simam@example.com')
        );
    }

    public function test_login_validation_failed()
    {
        $this->insertUserRecord();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'simam',
            'password' => '12314'
        ]);

        $response->assertStatus(422)->assertJson(fn (AssertableJson $json) => 
            $json->hasAny(['message', 'errors'])
        );
    }

    public function test_login_user_not_registered()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'asal@example',
            'password' => '12314899'
        ]);

        $response->assertStatus(404)->assertJson([
            'error' => 'Email has not registered'
        ]);
    }

    public function test_login_wrong_credentials()
    {
        $this->insertUserRecord();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@example.com',
            'password' => '12314899'
        ]);

        $response->assertStatus(401)->assertJson([
            'error' => 'Invalid credentials'
        ]);
    }

    public function test_login_success()
    {
        $this->insertUserRecord();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@example.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) => 
            $json->hasAll(['access_token', 'token_type', 'expires_in', 'user'])
                ->etc()
                ->where('user.email', 'user@example.com')
        );
    }

    public function test_logout_failed()
    {
        $response = $this
                    ->postJson('/api/v1/auth/logout')
                    ->assertStatus(401)
                    ->assertJson(fn (AssertableJson $json) => 
                        $json->where('message', "You're already signed out")
                    );
    }

    public function test_logout_success()
    {
        $this->generateAccessToken();
        $response = $this
                    ->postJson('/api/v1/auth/logout')
                    ->assertStatus(200)
                    ->assertJson(['message' => "User successfully signed out"]);
    }

    public function test_refresh_token_success()
    {
        $this->generateAccessToken();
        $response = $this
                    ->postJson('/api/v1/auth/refresh')
                    ->assertStatus(200)
                    ->assertJson(fn (AssertableJson $json) => 
                        $json->hasAll(['access_token', 'token_type', 'expires_in', 'user'])
                    );
    }

    public function test_user_profile_failed_unauthenticated()
    {
        $response = $this->getJson('/api/v1/user-profile')
                    ->assertStatus(401)
                    ->assertJson(['message' => 'User unauthenticated']);
    }

    public function test_user_profile_success()
    {
        $this->generateAccessToken();
        $response = $this->getJson('/api/v1/user-profile')
                    ->assertStatus(200)
                    ->assertJson(fn (AssertableJson $json) =>
                        $json->has('email')
                            ->etc()
                    );
    }
}
