<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /**
     * @test
     * This test case tests whether the model 'Driver' contains expected columns;
     */
    public function driver_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('driver', [
                'driver_id',
                'driver_pass',
                'driver_name',
                'driver_mobile_number',
                'maximum_Loading',
                'search_flg',
                'admin_flg',
                'car_no1',
                'car_no2',
                'car_no3',
                'car_type',
                'driver_remark',
                'delete_flg',
                'create_id',
                'created_at',
                'update_id',
                'updated_at'
            ]), 1);
    }

    /**
     * Test if drivers can be created
     */
    public function testCreateDriver()
    {
        $data = [
            'driver_name' => "Somebody",
            'driver_pass' => "test pass"
//            'driver_mobile_number' => "+6456312321654",
//            'maximum_Loading' => 10,
//            'search_flg' =>
        ];
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/products',$data);
        $response->assertStatus(200);
    }

    public function testGettingAllDrivers()
    {

    }

    public function testUpdateDriver()
    {

    }
}
