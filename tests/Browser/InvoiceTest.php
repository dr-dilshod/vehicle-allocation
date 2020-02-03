<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InvoiceTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
    /**
* test if the registration button is disabled in non-editing mode
*/
    public function testDisabledRegistrationButton() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/driver')
                ->assertButtonDisabled('registerBtn');
        });
    }
    /**
     * test if the editing text is not visible in non-editing mode
     */
    public function testInvisibleEditingText() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/driver')
                ->assertDontSee('Editing');
        });
    }
    /**
     * test if the registration button is enabled in editing mode
     */
    public function testEnabledRegistrationButton() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/driver')
                ->press('editBtn')
                ->assertButtonDisabled('registerBtn');
        });
    }

    /**
     * test if the editing text is visible in editing mode
     */
    public function testVisibleEditingText() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/driver')
                ->press('editBtn')
                ->assertSee('Editing');
        });
    }
}
