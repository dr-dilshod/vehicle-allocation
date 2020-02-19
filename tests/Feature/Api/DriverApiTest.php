<?php

namespace Tests\Feature\Api;

use App\Driver;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;
    private $driver;
    public function setUp(): void
    {
        parent::setUp();
        $this->driver = [
            'driver_pass' => 'DriverPass',
            'driver_name' => 'DriverName1',
            'driver_mobile_number' => '99998888899',
            'maximum_Loading' => '77',
            'search_flg' => '1',
            'admin_flg' => '1',
            'vehicle_no1' => '10',
            'vehicle_no2' => '555',
            'vehicle_no3' => '666',
            'vehicle_type' => 'Blank',
            'driver_remark' =>'Remarks for driver list',
            'delete_flg' => 0,
            ];
    }

/**
     * A basic feature test example.
     *
     * @return void
     */
    /**
     * Test the schema of Driver list
     */
    public function testDriverSchema()
    {
        $response = $this->json('GET', route('api.driver.index', [1]));
        $response
            ->assertJsonStructure(['*'=>[
                'driver_id', 'driver_pass', 'driver_name',
                'driver_mobile_number', 'maximum_Loading', 'search_flg',
                'admin_flg', 'vehicle_no1', 'vehicle_no2', 'vehicle_no3',
                'vehicle_type', 'driver_remark', 'delete_flg', 'remember_token',
                'create_id', 'update_id', 'created_at', 'updated_at']
            ]);
    }
    /**
     * Testing Driver creation
     */
    public function testCreateDriver(){
        $response = $this->json('POST', route('api.driver.store'), $this->driver);
        $response->assertStatus(201);
        $this->assertDatabaseHas('drivers',[  'driver_name' => 'DriverName1',
            'driver_mobile_number' => '99998888899']);
        Driver::orderBy('driver_id', 'DESC')->first()->delete();


    }
    /**
     * Testing structure of one record
     */
    public function testGetDriver(){
        $driver = factory(Driver::class)->create();
        $response = $this->json('GET', route('api.driver.show', [$driver->driver_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'driver_id', 'driver_pass', 'driver_name', 'driver_mobile_number', 'maximum_Loading',
                'search_flg', 'admin_flg', 'vehicle_no1', 'vehicle_no2',
                'vehicle_no3', 'vehicle_type', 'driver_remark', 'delete_flg', 'create_id',
                'update_id', 'created_at', 'updated_at']);
        Driver::find($driver->driver_id)->delete();
    }
    /**
     * Testing update one record
     */
    public function testUpdateDriver(){
        $update_data = $this->driver;
        $update_data['driver_mobile_number'] = '5454540';
        $new_driver = factory(Driver::class)->create($this->driver);
        $response = $this->json('PUT', route('api.driver.update',[$new_driver->driver_id]),
            $update_data);
        Driver::find($new_driver->driver_id)->delete();
        $response->assertStatus(200);
    }
    /**
    * Testing delete one record
     */
    public function testDeleteDriver(){

        $driver = factory(Driver::class)->create([
            'driver_name' => 'DriverName1']);
        $response = $this->json('DELETE',route('api.driver.destroy',[$driver->driver_id]));
        $response->assertStatus(204);
        Driver::find($driver->driver_id)->delete();

    }

    /**
     * Search condition:  Driver list. Delete flag	= 0
     */
    public function testSearchCondition()
    {
        $new_driver = factory(Driver::class)->create($this->driver);
        $response = $this->json('GET', route('api.driver.show', [$new_driver->driver_id]));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'delete_flg' => 0,
            ]);
        Driver::find($new_driver->driver_id)->delete();

    }



    /**
     * Acquisition data:  Driver list. Driver password
     * Acquisition data: Driver list. Driver name
     * Acquisition data: Driver list. driver's Mobile number
     * Acquisition data: Driver list. maximum loading
     * Acquisition data: Driver list. vehicle no1
     * Acquisition data: Driver list vehicle no2
     * Acquisition data: Driver list.vehicle no3
     * Acquisition data: Driver list.vehicle type
     * Acquisition data: Driver list. driver remarks
     */
    public function testDataAcquisition() {
        $driver = factory(Driver::class)->create([
            'driver_pass' => 'DriverPassword',
            'driver_name' => 'DriverName2',
            'driver_mobile_number' => '9989777777',
            'maximum_Loading' => '99',
            'search_flg' => '1',
            'admin_flg' => '1',
            'vehicle_no1' => '111',
            'vehicle_no2' => '222',
            'vehicle_no3' => '333',
            'vehicle_type' => 'Blank',
            'driver_remark' =>'Remarksfordriverlist',
            'delete_flg' => 0,
        ]);
        $response = $this->json('GET', route('api.driver.show', [$driver->driver_id]));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'driver_pass' => 'DriverPassword',
                'driver_name' => 'DriverName2',
                'driver_mobile_number' => '9989777777',
                'maximum_Loading' => '99',
                'vehicle_no1' => '111',
                'vehicle_no2' => '222',
                'vehicle_no3' => '333',
                'vehicle_type' => 'Blank',
                'driver_remark' =>'Remarksfordriverlist',
                'delete_flg' => 0,]);
        Driver::find($driver->driver_id)->delete();
    }


}
