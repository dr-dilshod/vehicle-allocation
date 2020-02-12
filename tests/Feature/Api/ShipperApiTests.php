<?php

use App\Shipper;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Created by PhpStorm.
 * User: N0D1R
 * Date: 08-Jan-20
 * Time: 11:27 AM
 */
class ShipperApiTests extends TestCase
{

    use WithoutMiddleware;
    private $shipper;

    public function setUp(): void
    {
        parent::setUp();
        $this->shipper = [
            'shipper_no' => '4444',
            'shipper_name1'=>'TestCompanyName1',
            'shipper_name2'=>'TestCompanyName1',
            'shipper_kana_name1'=>'TestCompanyName1',
            'shipper_kana_name2'=>'TestCompanyName1',
            'shipper_company_abbreviation'=>'LLC',
            'postal_code'=>'TestCompanyName1',
            'address1' => 'somewhere',
            'address2' => 'somewhere',
            'phone_number'=> '000000000',
            'fax_number'=> '000000000',
            'closing_date'=> 1,
            'delete_flg'=>0,
            'create_id' =>1,
            'created_at' =>'2020-01-01',
            'update_id'=>1,
            'updated_at'=>'2020-01-01',
        ];
    }

    /**
     * test the database schema for the result of index page
     */
    public function testShipperSchema()
    {
        $response = $this->json('GET', route('api.shipper.index', [1]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['shipper_id', 'shipper_no', 'shipper_name1', 'shipper_name2',
                        'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation',
                        'postal_code', 'address1', 'address2', 'phone_number', 'fax_number',
                        'closing_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at']
                ]
            ]);
    }

    /**
     * Testing shipper creation
     */
    public function testCreateShipper(){
        $response = $this->json('POST', route('api.shipper.store'), $this->shipper);
        $response->assertStatus(201);
        $this->assertDatabaseHas('shippers', $this->shipper);
        Shipper::where('shipper_no', '4444')->delete();
    }

    /**
     * Testing structure of one record and test getting one record
     */
    public function testGetShipper(){
        $shipper = factory(Shipper::class)->create($this->shipper);
        $response = $this->json('GET', route('api.shipper.show', [$shipper->shipper_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'shipper_id', 'shipper_no', 'shipper_name1', 'shipper_name2',
                'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation',
                'postal_code', 'address1', 'address2', 'phone_number', 'fax_number',
                'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'
            ]);
        $response->assertJsonFragment($this->shipper);
    }
    /**
     * Testing the update end point of Shipper API
     */
    public function testUpdateShipper() {
        $update_data = ['shipper_no' => '8888',
            'shipper_name1' => 'SecondTestShipperName1',
            'shipper_kana_name1' => 'TestShipperName1'];
        $new_shipper = factory(Shipper::class)->create($this->shipper);
        $response = $this->json('PUT', route('api.shipper.update',[$new_shipper]),
            $update_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('shippers', $update_data);
        Shipper::where('shipper_no', '8888')->delete();
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteShipper(){
        $shipper = factory(Shipper::class)->create($this->shipper);
        $response = $this->json('DELETE',route('api.shipper.destroy',[$shipper->shipper_id]));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('shippers', $this->shipper);
    }

    /**
     * Testing if the shipper names are distinct
     */
    public function testDistinctNames(){
        $shipper1 = factory(Shipper::class)->create($this->shipper);
        $new_shipper=$this->shipper;
        array_replace($new_shipper,['shipper_no'=>'5555']);
        $shipper2 = factory(Shipper::class)->create($new_shipper);
        $response = $this->json('GET', route('api.shipper.distinct-name'));
        $response->assertStatus(200)
            ->assertJsonCount(1);
        Shipper::where('shipper_no', '4444')->delete();
        Shipper::where('shipper_no', '5555')->delete();
    }
    /**
     * Testing if the shipper company names are distinct
     */
    public function testDistinctCompanies(){
        $shipper1 = factory(Shipper::class)->create($this->shipper);
        $new_shipper=$this->shipper;
        array_replace($new_shipper,['shipper_no'=>'5555']);
        $shipper2 = factory(Shipper::class)->create($new_shipper);
        $response = $this->json('GET', route('api.shipper.distinct-company'));
        $response->assertStatus(200)
            ->assertJsonCount(1);
        Shipper::where('shipper_no', '4444')->delete();
        Shipper::where('shipper_no', '5555')->delete();
    }

}
