<?php

namespace Tests\Feature\Feature\Api;

use App\Vehicle;
use mysql_xdevapi\Table;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class VehicleApiTest
 * @package Tests\Feature\Feature\Api
 * @author Dilshod K
 */
class VehicleApiTest extends TestCase
{

    //use WithoutMiddleware;

    use WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        // seeding test data in the data base
        $user = Vehicle::create([
            $this->faker->firstName()
        ]);
        $test_data = [
            'vehicle_no' => '0000',
            'company_name' => 'TestCompanyName',
            'driver_name' => 'TestDriverName',
            'offset' => 0,
            'delete_flg'=> 0
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($test_data));
        $vehicleController = new VehicleController();
        $fetch = $vehicleController->store($request);
    }

    /**
     * Test the schema of vehicle table
     */
    public function testVehicleSchema()
    {
        $response = $this->json('GET', route('api.vehicle.index'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'vehicle_id', 'vehicle_no', 'company_name', 'company_kana_name', 'vehicle_company_abbreviation',
                    'vehicle_postal_code', 'vehicle_address1', 'vehicle_address2', 'vehicle_phone_number',
                    'vehicle_fax_number', 'offset', 'vehicle_remark', 'delete_flg', 'create_id',
                    'update_id', 'created_at', 'updated_at']
            ]);
    }

    /**
     * Testing vehicle creation
     */
    public function testCreateVehicle(){
        $vehicle = factory(Vehicle::class)->make([
            'company_name' => 'TestCompanyName1']);
        $response = $this->json('POST', route('api.vehicle.store'), $vehicle->toArray());
        $response->assertStatus(201);
        assertTrue(DB::table('vehicles')->where('company_name', 'TestCompanyName1')->exists());
        DB::table('vehicles')->where('company_name', '=', "TestCompanyName1")->delete();
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

    public function testUpdateVehicle(){
        $id = factory(Vehicle::class)->create()->vehicle_id;
        $vehicle = factory(Vehicle::class)->make();
        $response = $this->json('PUT', route('api.vehicle.update',[$id]), $vehicle->toArray());
        $response->assertStatus(200);
    }

    public function testDeleteVehicle(){
        $vehicle = factory(Vehicle::class)->create([
            'company_name' => 'TestCompanyName']);
        $response = $this->json('DELETE',route('api.vehicle.destroy',[$vehicle->vehicle_id]));
        $response->assertStatus(204);
        assertFalse(DB::table('vehicles')->where('company_name', 'TestCompanyName')->exists());
    }

     /**
     * Data Structure: Car rental master.Car rental company (DISTINCT)
     */
    public function testCarCompanyStructure()
    {
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertStatus(200)
            ->assertJsonStructure(
                ['vehicle_id', 'company_name']
            );
    }

    /**
     * Data Acquisition: Car rental master.Car rental company (DISTINCT)
     */
    public function testCarCompanyDataAcqusition()
    {
        // write the same company name twice, then check if only one is displayed
        // $faker = Faker::create('App\Vehicle');
        DB::table('vehicles')->insert([
            'vehicle_no' => '0000',
            'company_name' => 'TestCompanyNameDistict',
            'offset' => 0,
            'delete_flg'=>0,
        ]);
        DB::table('vehicles')->insert([
            'vehicle_no' => '0000',
            'company_name' => 'TestCompanyNameDistict',
            'offset' => 0,
            'delete_flg'=>0,
        ]);
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertJsonCount('1','company_name','TestCompanyNameDistict');
        DB::table('vehicles')->where('company_name', '=', "TestCompanyNameDistict")->delete();
    }

    /**
     * Search condition: Rental vehicle master. Delete flag	= 0
     */
    public function testSearchCondition()
    {
        $response = Vehicle::select()
            ->where('company_name', 'TestCompanyName')
            ->get();
        $response -> assertStatus(200)
            -> assertJsonFragment([
            'delete_flg' => 0,
        ]);
    }

    /**
    * Acquisition data: Rental vehicle master Rental vehicle No.
    */
    public function testRentalVehicleNo()
    {
        $response = $this->json('GET', route('vehicle.companies'));
        $response->assertStatus(200)
            ->assertJsonFragment([
                'vehicle_no' => '0000',
            ]);
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

    /**
     * 2-1. When the edit button is pressed: Display "Editing" and enter edit mode.
     */
    public function testEditingMode() {
        $user = factory(Driver::class)->create([
            'driver_name' => 'admin',
            'driver_pass' => 'admin'
        ]);
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('driver_name', $user->driver_name)
                ->type('password', $user->driver_pass)
                ->press('Login')
                ->assertPathIs('/home');
        });
    }


    /**
     * When the edit button is pressed: 2-2. Activate the “Register” button.
     */


    /**
     * 3. When the search button is pressed: Search condition:
     * Rental car master. Rental car company name= Rental car company.Select box
     */

    /**
     * 3. When the search button is pressed: Search condition:
     * Rental car master. Delete flag = 0
     */
    /**
     * 3. When the search button is pressed: Display order
     * Rental car master. Rental car No.
     */

    /**
     * 4. When the clear button is pressed:
     * 4-1. Leave the following search condition items blank.
     * Rental car company.Select box
     */

    /**
     * 5. When the registration button is pressed:
     * 5-1. Input check
     * Indispensable check If the charter vehicle number or charter company name is not entered
     * Message ID						｛0｝						Message
     * MSG07						Merchant vehicle No				Please enter {0}
     */


    /**
     * 5. When the registration button is pressed:
     * 5-1. Input check
     * Indispensable check If the charter vehicle number or charter company name is not entered
     * Message ID						｛0｝						Message
     * MSG07						Rental car company name			Please enter {0}.
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental vehicle master Rental vehicle No.	=	Merchant vehicle number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Rental car company name = Car rental company name.text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Furigana (company name) =	 Furigana (company name). Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. =	 Abbreviation: text box
     */
    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Postal code = Postcode or text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. Address 1 = Address 1. Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Charter Master. Address 2 = Address 2. Text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Phone number = Phone number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.FAX number = Fax number text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = Offset.text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = Remarks: text box
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master.Updater ID = Update user
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update data
     * Rental car master. = TODAY
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update condition
     * Rental car master. Rental car ID = Selection data.Car rental ID
     */

    /**
     * 5-2. When updating the data in the chart of rental cars.
     * ・ Update condition
     * A pop-up is displayed as three common specifications, and the edit mode ends.
     */




    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Rental car IDautomatic numbering
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental vehicle master Rental vehicle No. = Merchant vehicle number text box
     */

     /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Rental car company name = Car rental company name.text box
     */

    /** 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Furigana (company name) = Furigana (company name). Text box
     */

    /**  5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Abbreviation: text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Postal code = Postcode or text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. Address 1 = Address 1. Text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Charter Master. Address 2 = Address 2. Text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Phone number = Phone number text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.FAX number = Fax number text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Offset.text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = Remarks: text box
     */

    /**
     * 5-3. When registering data of the chartered vehicle list
     * ・ Update data
     * Rental car master, registrant ID = Update user
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = TODAY
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master.Updater ID = Update user
     */

    /**
     * 5-3. When registering data of the chartered vehicle list.
     * ・ Update data
     * Rental car master. = TODAY
     */

}
