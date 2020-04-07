<?php

namespace Tests\Browser;


use App\Driver;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DispatchTest extends DuskTestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = Driver::query()->where('driver_id', 1)->first();
    }

    public function testDate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit('/dispatch')
                ->assertInputValue('dispatch_day', Carbon::today('Asia/Tokyo')->format('Y/m/d'));
        });
    }

    public function testNextDayClick()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit('/dispatch')
                ->click('#nextDay')
                ->assertInputValue('dispatch_day', Carbon::today('Asia/Tokyo')
                    ->addDays(1)
                    ->format('Y/m/d'));
        });
    }

    public function testNextTwoDaysClick()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit('/dispatch')
                ->click('#twoDaysLater')
                ->assertInputValue('dispatch_day', Carbon::today('Asia/Tokyo')
                    ->addDays(2)
                    ->format('Y/m/d'));
        });
    }

    public function testBackButton()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit('/dispatch')
                ->click('#app > main > div > div:nth-child(1) > div:nth-child(1) > a')
                ->assertRouteIs('top');
        });
    }

    public function testDialogButton()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit('/dispatch')
                ->click('#app > main > div > div:nth-child(3) > div.col-8 > table > tfoot > tr > td > button')
                ->assertAttribute('#addDriverModal', 'class', 'modal show');
        });
    }
}
