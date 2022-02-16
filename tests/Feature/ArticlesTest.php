<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_detail_page() {
        $response = $this->get('/detail/3');
        $response->assertStatus(200);
    }

    public function test_detail_not_found() {
        $response = $this->get('/detail/100');
        $response->assertRedirect('/');
    }

    public function test_blog_index_page() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    public function test_blog_index_with_filter_condition() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->get('/blog?status_filtering=1&published_filtering=2022-02-16');
        $response->assertStatus(200);
    }

    public function test_blog_create_page() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->get('/blog/create');
        $response->assertStatus(200);
    }

    public function test_blog_store_page() {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->call('POST', '/blog', [
            'title' => 'Just for test' . rand(),
            'content' => 'Content for test',
            '_token' => csrf_token()
        ]);

        $response->assertRedirect('/blog');
    }

    public function test_blog_store_failed_page() {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->call('POST', '/blog', [
            'title' => 'Just for test',
            'content' => 'Content for test',
            '_token' => csrf_token()
        ]);

        $response->assertRedirect('/blog');
    }

    public function test_blog_edit_page() {
        $user = new User(array('name' => 'John', 'role'=>'Admin'));
        $this->be($user);
        $response = $this->get('/blog/1/edit');
        $response->assertStatus(200);
    }

    public function test_blog_edit_failed_page() {
        $user = new User(array('name' => 'John', 'role'=>'User'));
        $this->be($user);
        $response = $this->get('/blog/1/edit');
        $response->assertStatus(302);
    }

    public function test_blog_update_now_owner_page() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->actingAs($user)->call('PUT', '/blog/1', [
            'title' => 'Just for test' . rand(),
            'content' => 'Content for test',
            '_token' => csrf_token()
        ]);
        $response->assertStatus(302);
    }

    public function test_blog_update_admin_without_params_page() {
        $user = new User(array('name' => 'John', 'role' => 'Admin'));
        $this->be($user);
        $response = $this->actingAs($user)->call('PUT', '/blog/1', [
            'title' => 'Just for test' . rand(),
            'content' => 'Content for test',
            '_token' => csrf_token()
        ]);
        $response->assertStatus(302);
    }

    public function test_blog_update_admin_with_params_page() {
        $user = new User(array('name' => 'John', 'role' => 'Admin'));
        $this->be($user);
        $response = $this->actingAs($user)->call('PUT', '/blog/1', [
            'title' => 'Just for test' . rand(),
            'content' => 'Content for test',
            'status' => 1,
            'published' => '2022-02-16 21:17:00',
            '_token' => csrf_token()
        ]);
        $response->assertStatus(302);
    }

    public function test_blog_destroy_admin_page() {
        $user = new User(array('name' => 'John', 'role' => 'Admin'));
        $this->be($user);
        $response = $this->actingAs($user)->call('DELETE', '/blog/26');
        $response->assertStatus(302);
    }

    public function test_blog_destroy_not_admin_page() {
        $user = new User(array('name' => 'John'));
        $this->be($user);
        $response = $this->actingAs($user)->call('DELETE', '/blog/25');
        $response->assertStatus(302);
    }
}
