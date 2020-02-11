<?php

namespace Tests\Browser;

use App\Driver;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicleTest extends DuskTestCase
{
    private $user;
    public function setUp(): void
    {
        parent::setUp();
    }
    /**
     * test successful login into top
     */

    public function testLoginIntoTop() {
        $this->browse(function ($browser) {
            $browser->visit('/')
                ->type('driver_name', 'admin')
                ->type('password', 'admin')
                ->press('login')
                ->assertPathIs('/');
        });

    }
    /**
     * test if the registration button is disabled in non-editing mode
     */
    public function testDisabledRegisterButton() {
        $this->browse(function ($browser) {
            $browser->visit('/vehicle')
                ->assertButtonDisabled('registerBtn');
        });
    }

    /**
     * test if the registration button is disabled in non-editing mode
     */
    public function testInvisibleEditingText() {
        $this->browse(function ($browser) {
            $browser->visit('/vehicle')
                ->assertDontSee('編集中');
        });
    }

    /**
     * test if the registration button is enabled in editing mode
     */
    public function testEnabledRegistrationButton() {
        $this->browse(function ($browser) {
            $browser->visit('/vehicle')
                ->press('editBtn')
                ->assertButtonEnabled('registerBtn');
        });
    }

    /**
     * test if the editing text is visible in editing mode
     */
    public function testVisibleEditingText() {
        $this->browse(function ($browser) {
            $browser->visit('/vehicle')
                ->press('editBtn')
                ->assertSee('編集中');
        });
    }
}
