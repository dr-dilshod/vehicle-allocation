<?php

namespace Tests\Feature\Feature\Api;

use App\Driver;
use App\Vehicle;
use Illuminate\Auth\Access\Gate;
use mysql_xdevapi\Table;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


/**
 * Class VehicleApiTest
 * @package Tests\Feature\Feature\Api
 * @author Dilshod K
 */
class VehicleApiTest extends TestCase
{

    use WithFaker;
    use WithoutMiddleware;
    private $vehicle;

    public function setUp(): void
    {
        parent::setUp();
        $this->vehicle = [
            'vehicle_no' => '4444',
            'company_name' => 'TestCompanyName1',
            'company_kana_name' => 'TestCompanyName1',
            'vehicle_company_abbreviation' => 'TestCompanyName1',
            'vehicle_postal_code' => 'TestCompanyName1',
            'vehicle_address1' => 'Address1',
            'vehicle_address2' => 'Address2',
            'offset' => '0',
            'vehicle_phone_number' => '5555555',
            'vehicle_fax_number' => '5555555',
            'delete_flg' => '0'];
    }

    /**
     * Test the schema of vehicle table
     */
    public function testVehicleSchema()
    {
        $response = $this->json('GET', route('api.vehicle.index', [1]));
        $response
            ->assertJsonStructure(['*'=>
                    ['vehicle_id', 'vehicle_no', 'company_name', 'company_kana_name', 'vehicle_company_abbreviation',
                    'vehicle_postal_code', 'vehicle_address1', 'vehicle_address2', 'vehicle_phone_number',
                    'vehicle_fax_number', 'offset', 'vehicle_remark', 'delete_flg', 'create_id',
                    'update_id', 'created_at', 'updated_at']]
            );
    }

    /**
     * Testing vehicle creation
     */
    public function testCreateVehicle(){
        $response = $this->json('POST', route('api.vehicle.store'), $this->vehicle);
        $response->assertStatus(201);
        $this->assertDatabaseHas('vehicles', $this->vehicle);
        Vehicle::where('vehicle_no', '4444')->delete();
    }



    /**
     * Testing structure of one record
     */
    public function testGetVehicle(){
        $vehicle = factory(Vehicle::class)->create();
        $response = $this->json('GET', route('api.vehicle.show', [$vehicle->vehicle_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'vehicle_id', 'vehicle_no', 'company_name', 'company_kana_name', 'vehicle_company_abbreviation',
                'vehicle_postal_code', 'vehicle_address1', 'vehicle_address2', 'vehicle_phone_number',
                'vehicle_fax_number', 'offset', 'vehicle_remark', 'delete_flg', 'create_id',
                'update_id', 'created_at', 'updated_at']);
    }

    /**
     * Testing the update end point of API
     */
    public function testUpdateVehicle(){
        $update_data = ['vehicle_no' => '8888',
            'company_name' => 'SecondTestCompanyName1',
            'company_kana_name' => 'TestCompanyName1'];
        $new_vehicle = factory(Vehicle::class)->create($this->vehicle);
        $response = $this->json('PUT', route('api.vehicle.update',[$new_vehicle->vehicle_id]),
            $update_data);
        Vehicle::where('vehicle_no', '8888')->delete();
        $response->assertStatus(200);
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteVehicle(){
        $vehicle = factory(Vehicle::class)->create([
            'company_name' => 'TestCompanyName']);
        $response = $this->json('DELETE',route('api.vehicle.destroy',[$vehicle->vehicle_id]));
        $response->assertStatus(204);
    }

     /**
     * Data Structure: Car rental master.Car rental company (DISTINCT)
     */
    public function testCarCompanyStructure()
    {
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertStatus(200);
    }

    /**
     * Data Acquisition: Car rental master.Car rental company (DISTINCT)
     */
    public function testCarCompanyDataAcqusition()
    {
        // write the same company name twice, then check if only one is displayed
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertStatus(200);
    }

    /**
     * Search condition: Rental vehicle master. Delete flag	= 0
     */
    public function testSearchCondition()
    {
        $new_vehicle = factory(Vehicle::class)->create($this->vehicle);
        $response = $this->json('GET', route('api.vehicle.show', [$new_vehicle->vehicle_id]));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'delete_flg' => 0,
        ]);
        Vehicle::where('vehicle_no', '4444')->delete();

    }

    /**
    * Acquisition data: Rental vehicle master Rental vehicle No.
    */
    public function testRentalVehicleNo()
    {
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertStatus(200);
    }

    /**
     * Acquisition data: Rental vehicle master. Rental vehicle company name
     * Acquisition data: Rental vehicle master. Furigana (company name)
     * Acquisition data: Rental vehicle master.
     * Acquisition data: Rental vehicle master.Postal code
     * Acquisition data: Rental vehicle master. Address 1
     * Acquisition data: Charter Master. Address 2
     * Acquisition data: Rental vehicle master.Phone number
     * Acquisition data: Rental vehicle master.FAX number
     */
    public function testDataAcquisition() {
        $vehicle = factory(Vehicle::class)->create([
            'vehicle_no' => '0000',
            'company_name' => 'TestCompanyName',
            'company_kana_name' => 'TestCompanyKanaName',
            'vehicle_company_abbreviation' => 'vehicle_company_abbreviation',
            'vehicle_postal_code' => '220100',
            'vehicle_address1' => '',
            'vehicle_address2' => '',
            'vehicle_phone_number' => '+9986333333',
            'vehicle_fax_number' => '9986333333',
            'vehicle_remark' => 'test remark',
        ]);
        $response = $this->json('GET', route('api.vehicle.show', [$vehicle->vehicle_id]));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'vehicle_no' => '0000',
                'company_name' => 'TestCompanyName',
                'company_kana_name' => 'TestCompanyKanaName',
                'vehicle_company_abbreviation' => 'vehicle_company_abbreviation',
                'vehicle_postal_code' => '220100',
                'vehicle_address1' => '',
                'vehicle_address2' => '',
                'vehicle_phone_number' => '+9986333333',
                'vehicle_fax_number' => '9986333333',
                'vehicle_remark' => 'test remark',
            ]);
    }
}
