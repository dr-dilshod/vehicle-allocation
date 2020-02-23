<?php

namespace Tests\Feature\Api;

use App\Deposit;
use App\Driver;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;


class DepositApiTest extends TestCase
{
    use WithoutMiddleware;

    private $deposit;
    public function setUp(): void
    {
        parent::setUp();
        $this->deposit = [
            'shipper_id'=>2,
            'deposit_day' => "2000-01-01 01:01:01",
            "deposit_amount" => 3000,
            'other' => 3000,
            'fee' => 3000,
            'delete_flg' => 0,
            'create_id'=>Driver::orderBy('driver_id', 'DESC')->first()->driver_id,
            'created_at' => "2000-01-01 01:01:01",
            'update_id'=>Driver::orderBy('driver_id', 'DESC')->first()->driver_id,
            'updated_at' => "2000-01-01 01:01:01"

        ];
    }
    /**
     * test the database schema for the result of index page
     */
    public function testDepositSchema()
    {
        $deposit = factory(\App\Deposit::class)->create($this->deposit);
        $depositInDB = Deposit::where('shipper_id', 2)
            ->get()->first();
        $response = $this->json('GET', route('deposit.filter', [1]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    ['shipper_id', 'deposit_day', 'deposit_amount', 'other',
                        'fee', 'delete_flg', 'create_id', 'update_id', 'created_at', 'updated_at']
                ]
            ]);
        Deposit::where('deposit_id', $depositInDB->deposit_id)->delete();
    }

}
