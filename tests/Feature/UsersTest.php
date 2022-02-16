<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    public function test_login_page() {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_logout_page() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->get('/logout');
        $response->assertRedirect('/');
    }

    public function test_authenticate_failed_page() {
        $response = $this->call('POST', '/authenticate', [
            'email' => 'badUsername@gmail.com',
            'password' => 'badPass',
            '_token' => csrf_token()
        ]);
        $response->assertRedirect('/');
    }

    public function test_authenticate_success_page() {
        $response = $this->call('POST', '/authenticate', [
            'email' => 'quang@gmail.com',
            'password' => '123456',
            '_token' => csrf_token()
        ]);

        $response->assertRedirect('/');
    }
}
