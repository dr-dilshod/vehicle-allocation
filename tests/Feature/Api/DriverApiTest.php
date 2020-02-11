<?php

namespace Tests\Feature\Api;

use App\Driver;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverApiTest extends TestCase
{
    use WithoutMiddleware;
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
        $user = Driver::findOrFail(1);
        $response = $this
            ->actingAs($user)
            ->json('GET', route('api.driver.index'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'create_id', 'update_id', 'driver_pass', 'driver_name', 'driver_mobile_number',
                    'maximum_Loading', 'search_flg', 'admin_flg', 'vehicle_no1', 'vehicle_no2',
                    'vehicle_no3', 'vehicle_type', 'driver_remark', 'delete_flg',
                    'created_at', 'updated_at']
            ]);
    }
    /**
     * Testing Driver creation
     */
    public function testCreateDriver(){

        $driver = factory(Driver::class)->make();

        $response = $this->json('POST', route('api.driver.store'), $driver->toArray());

        $response->assertStatus(201);
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
