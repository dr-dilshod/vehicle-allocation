<?php

namespace Tests\Browser;

use App\Driver;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SettingTest extends DuskTestCase
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

    public function testSettingPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/top')
                ->clickLink('setting')
                ->assertSee("Setting")
                ->assertPathIs('/setting');
        });
    }

    public function testSettingBackPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.back')
                ->assertSee("Top")
                ->assertPathIs('/top');
        });
    }

    public function testDriverListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.driver_list')
                ->assertSee("Driver list")
                ->assertPathIs('/driver');
        });
    }

    public function testShipperListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.shipper_list')
                ->assertSee("Shipper list")
                ->assertPathIs('/shipper');
        });
    }

    public function testVehicleListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.car_list')
                ->assertSee("Vehicle list")
                ->assertPathIs('/vehicle');
        });
    }

    public function testUnitPriceListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.list_of_unit_prices')
                ->assertSee("Unit price list")
                ->assertPathIs('/unit-price');
        });
    }
}
