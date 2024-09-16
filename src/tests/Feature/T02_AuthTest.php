<?php


use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

Class T02_AuthTest extends TestCase
{
    /** @test */
    public function userCanRegisterAndLogin()
    {
        // Open login page
        $response = $this->get(route('register', [], false));
        $response->assertStatus(200);

        // Register
        $response = $this->post(route('register', [], false), [
            'name' => 'unit',
            'email' => 'unit@unit.sk',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertRedirect(route('todo.task.list', [], false));

        $response = $this->get(route('logout', [], false));
        $response->assertRedirect(route('login', [], false));

        $response = $this->get(route('login', [], false));
        $response->assertStatus(200);

        // Log in
        $response = $this->post(route('login', [], false), [
            'email' => 'unit@unit.sk',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('todo.task.list', [], false));
    }
}


