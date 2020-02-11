<?php

namespace Tests\Browser;

use App\Driver;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InvoiceTest extends DuskTestCase
{
    private $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = Driver::select(['driver_name', 'driver_pass'])
            ->where('delete_flg', 0)
            ->where('search_flg', 1)
            ->where('admin_flg', 1)
            ->get();
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
                ->assertDontSee('編集中');
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
                ->assertSee('編集中');
        });
    }
}
