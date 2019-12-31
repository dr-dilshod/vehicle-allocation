<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
/**
 * Class RegisterTest
 * @package Tests\Feature
 * @author  Dilshod K
 */
class RegisterTest extends TestCase
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
     * Test if a valid user can be registered.
     * @return void
     */
    public function testRegistersAValidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->post('register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
    }
    /**
     * Test if an invalid user is not registered.
     * @return void
     */
    public function testDoesNotRegisterAnInvalidUser()
    {
        $user = factory(User::class)->make();
        $response = $this->post('register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
