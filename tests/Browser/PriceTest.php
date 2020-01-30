<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PriceTest extends DuskTestCase
{
    /**
     * test if the registration button is disabled in non-editing mode
     */
    public function testDisabledRegistrationButton() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/unit-price')
                ->assertButtonDisabled('registerBtn');
        });
    }

    /**
     * test if the editing text is not visible in non-editing mode
     */
    public function testInvisibleEditingText() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/unit-price')
                ->assertDontSee('Editing');
        });
    }

    /**
     * test if the registration button is enabled in editing mode
     */
    public function testEnabledRegistrationButton() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/unit-price')
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
            $browser->visit('/unit-price')
                ->press('editBtn')
                ->assertSee('Editing');
        });
    }
}
