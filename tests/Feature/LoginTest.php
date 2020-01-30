<?php

namespace Tests\Feature;

use App\Driver;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class LoginTest
 * @package Tests\Feature
 * @author Dilshod K
 */
class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if the registration form can be displayed.
     * @return void
     */
    public function testRegisterFormDisplayed()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Test if the login form can be displayed.
     * @return void
     */
    public function testLoginFormDisplayed()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    /**
     * Test if a valid user can be logged in.
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = factory(Driver::class)->create();
        $response = $this->post('/login', [
            'driver_name' => $user->driver_name,
            'password' => 'admin'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }
    /**
     * Test if an invalid user cannot be logged in.
     * @return void
     */
    public function testDoesNotLoginAnInvalidUser()
    {
        $user = factory(Driver::class)->create();
        $response = $this->post('/login', [
            'driver_name' => $user->email,
            'password' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
    /**
     * Test if a logged in user can be logged out.
     * @return void
     */
    public function testLogoutAnAuthenticatedUser()
    {
        $user = factory(Driver::class)->create();
        $response = $this->actingAs($user)->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
    }
}
