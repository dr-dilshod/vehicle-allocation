<?php

namespace Tests\Unit;

use App\Http\Controllers\DriverController;
use Doctrine\DBAL\Schema\Table;
use Tests\TestCase;
use App\Driver;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Class DriverTest
 * @package Tests\Unit
 * @author Dilshod K
 */
class DriverTest extends TestCase
{

    /**
     * A basic unit test example.
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
        $test_data = [
            'driver_pass' => 'testInsertion',
            'driver_name' => 'testInsertion',
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($test_data));
        $driverController = new DriverController();
        $update = $driverController->store($request);
        $count = \DB::table('drivers')
            ->where("driver_pass", "=", "testInsertion")
            ->where("driver_name", "=", "testInsertion")
            ->count();
        DB::table('drivers')->where('driver_pass', '=', "testInsertion")->delete();
        $this ->assertEquals(1,$count);
    }

    /**
     * Test if a driver can be updated
     */
    public function testUpdateDriver()
    {
            $test_data = [
            'driver_pass' => 'test',
                'driver_name' => 'Test',
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($test_data));
        $driverController = new DriverController();
        $update = $driverController->update($request, 1);
        $count = \DB::table('drivers')
            ->where("driver_pass", "=", "test")
            ->where("driver_name", "=", "test")
            ->count();
        $this ->assertEquals(1,$count);
    }

    /**
     * Test if a driver can be deleted
     */
    public function testDeleteDriver()
    {
        // first, insert a record into the database
        DB::table('drivers')->insert(
            ['id' => 100,
                'driver_name' => 'testDeletion', 'driver_pass' => 'testDeletion']
        );
        $test_data = [
            'driver_name' => 'testDeletion',
        ];

        $driverController = new DriverController();
        $update = $driverController->destroy('100');
        $count = \DB::table('drivers')
            ->where("driver_pass", "=", "testDeletion")
            ->count();
        $this ->assertEquals(0,$count);
    }

}
