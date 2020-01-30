<?php

namespace Tests\Browser;

use App\Driver;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TopTest extends DuskTestCase
{
    private $user;
    public function setUp(): void
    {
        $user = factory(Driver::class)->create([
            'driver_name' => 'admin',
            'driver_pass' => 'admin'
        ]);
        $this->user = $user;
    }

    /** 1. Initial display
     * 1-1. Display as above screen.
     */
    public function testTopScreen() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('driver_name', $user->driver_name)
                ->type('password', $user->driver_pass)
                ->press('Login')
                ->assertPathIs('/top');
        });
    }

    /**
     * 1-2. If you are an administrator, do the following.
     * 1-2-1. Obtain the following information in the select box.
     * ·Year
     * Initially display the current year.
     */
    public function testDisplayCurrentYear() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/top')
                ->within(new DatePicker, function ($browser) {
                    $browser->selectDate(2020, 1, 30);
                })
                ->assertSee('2020');
        });
    }

    /**
     * Get the past two years
     * In the case of 2020, get `` 2018 '', `` 2019 '', `` 2020 ''
     * ·Month
     * Initially display the current month.
     * Get 1-12
     * Inactive for general users
     */
    public function testDisplayCurrentMonth() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/top')
                ->within(new DatePicker, function ($browser) {
                    $browser->selectDate(2020, 1, 30);
                })
                ->assertSee('January');
        });
    }

    /**
     * 1-2-2. Obtain the following information in the driver sales list.
     * ・ Acquisition data
     * Driver master.Driver name									DISTINCT
     */
    public function testDriverName() {

    }
    /** Opportunity table.Amount									SUM
     * ・ Search condition
     * Issue table.							=		Today's date
    Matter table.State							=		1
    Matter table. Delete flag							=		0
    ·Display order
    Driver master.Driver name									ascending order
    ・ Join table
    Driver master
     */
    public function testSearchCondition() {

    }

    /**
     *
     * 1-3. If there is no administrator, perform the following processing.
    Deactivate the following:
    ・ Year.Select box
    ・ Month.Select box
    ・ Display button
     */
    public function testDeactivationForNonAdmin() {

    }
    /**
     * 2. When the matter registration button is pressed, the following processing is performed.
     * 2-1. Transit to the “Matter registration” screen.
     */
    public function testItemRegistrationPage() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->clickLink('top.item_reg')
                ->assertSee("Item Registration")
                ->assertPathIs('/item/create');
        });
    }

    /**
     * 3 When the Matter list button is pressed, the following processing is performed.
     * 3-1. Transit to the “Item list” screen.
     */
    public function testItemListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/top')
                ->clickLink('top.item_list')
                ->assertSee("Item List")
                ->assertPathIs('/item/create');
        });
    }

    /**
     * 4. When the dispatch button is pressed, the following processing is performed.
     * 4-1. Transit to the “vehicle allocation management” screen.
     */
    public function testVehicleDispatchPage() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->clickLink('top.dispatch_board')
                ->assertSee("Dispatch board")
                ->assertPathIs('/dispatch');
        });
    }

    /**
     * 5. When the billing management button is pressed, the following processing is performed.
     * 5-1. Transit to the “Bill Management” screen.
     * Active only for admin users
     */
    public function testInvoiceListPage() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->clickLink('top.billing_management')
                ->assertSee("Invoice list")
                ->assertPathIs('/invoice');
        });
    }

    /**
     * 6. When the payment list button is pressed, the following processing is performed.
     * 6-1. Transit to the “Payment List” screen.
     * Active only for admin users
     */
    public function testPaymentListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/payment')
                ->assertSee("Payment List")
                ->assertPathIs('/payment');
        });
    }

    /**
     * 7. When the payment list button is pressed, the following processing is performed.
     *  7-1. Transit to the “Payment List” screen.
     * Active only for admin users
     */
    public function testPaymentListForAdminPage() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->clickLink('top.payment_list')
                ->assertSee("Payment list")
                ->assertPathIs('/payment');
        });
    }
    public function testDepositListForAdminPage() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->clickLink('top.deposit_list')
                ->assertSee("Deposit list")
                ->assertPathIs('/deposit');
        });
    }
    /**  8. When the setting button is pressed, the following processing is performed.
    8-1. Transit to “Setting” screen.
     */
    public function testSettingPage() {
        $this->browse(function ($browser) {
            $browser->visit('/top')
                ->press('setting')
                ->assertSee("Setting")
                ->assertPathIs('/setting');
        });
    }

    /**
     * 9. When the display button is pressed, the following processing is performed.
    9-1. Only the administrator acquires the following information in the driver sales list.
    ・ Acquisition data
    Driver master.Driver name									DISTINCT
    Opportunity table.Amount									SUM
    ・ Search condition
    Issue table.							=		Year.select box						+		Month.select box
    Matter table.State							=		1
    Matter table. Delete flag							=		0
    ·Display order
    Driver master.Driver name									ascending order
    ・ Join table
    Driver master
    Matter table

     */

    /**
     * 10. When the login button is pressed, the following processing is performed.
    One common specification.
     */
    public function testLoginPressed() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/top')
                ->assertPathIs('/login');
        });
    }
    /**
     * wrong path test
     */
    public function testWrongPath() {
        $user = $this->user;
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/wrongPath')
                ->assertSee('Requested page not found.')
                ->assertPathIs('/wrongPath');
        });
    }
}
