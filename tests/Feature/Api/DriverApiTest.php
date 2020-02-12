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
        echo $response->getContent();
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
        $this->assertDatabaseHas('vehicles', $this->vehicle);
        Vehicle::where('vehicle_no', '4444')->delete();
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
    }
    /**
     * Testing update one record
     */
    public function testUpdateDriver(){
        $id = factory(Driver::class)->create()->driver_id;
        $driver = factory(Driver::class)->make();
        $response = $this->json('PUT', route('api.driver.update',[$id]),
            $driver->toArray());
        $response->assertStatus(200);
    }
    /**
    * Testing delete one record
     */
    public function testDeleteDriver(){

        $driver = factory(Driver::class)->create();

        $response = $this->json('DELETE',route('api.driver.destroy',[$driver->driver_id]));

        $response->assertStatus(204);
    }

}
