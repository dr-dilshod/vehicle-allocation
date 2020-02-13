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
        parent::setUp();
        $this->user = Driver::select(['driver_name', 'driver_pass'])
            ->where('delete_flg', 0)
            ->where('search_flg', 1)
            ->where('admin_flg', 1)
            ->get();
    }

    public function testSettingPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/top')
                ->clickLink('setting')
                ->assertSee("設定")
                ->assertPathIs('/setting');
        });
    }

    public function testDriverListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.driver_list')
                ->assertSee("ドライバー一覧")
                ->assertPathIs('/driver');
        });
    }

    public function testShipperListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.shipper_list')
                ->assertSee("荷主一覧")
                ->assertPathIs('/shipper');
        });
    }

    public function testVehicleListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.car_list')
                ->assertSee("傭車一覧")
                ->assertPathIs('/vehicle');
        });
    }

    public function testUnitPriceListPage() {
        $user = $this->user;
        $this->browse(function ($browser) {
            $browser->visit('/setting')
                ->clickLink('setting.list_of_unit_prices')
                ->assertSee("単価一覧")
                ->assertPathIs('/unit-price');
        });
    }
}
