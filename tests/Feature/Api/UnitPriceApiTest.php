<?php
/**
 * Created by PhpStorm.
 * User: Bekmurod
 * Date: 13.02.2020
 * Time: 18:56
 */


namespace Tests\Feature\Api;




use App\Driver;
use App\UnitPrice;
use App\Shipper;
use App\Item;
use Illuminate\Auth\Access\Gate;
use mysql_xdevapi\Table;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;



class UnitPriceApiTest extends TestCase
{

    use WithFaker;
    use WithoutMiddleware;
    private $UnitPrice;

    public function setUp(): void
    {
        parent::setUp();
        $this->UnitPrice = [
            'shipper_id' => Shipper::orderBy('shipper_id', 'DESC')->first()->shipper_id,
            'item_id'=>Item::orderBy('item_id', 'DESC')->first()->item_id,
            'driver_id'=>Driver::orderBy('driver_id', 'DESC')->first()->driver_id,
            'type' => 123,
            'price' => 555,
            'car_type' => 'trailer',
            'stack_point' => 'urganch123',
            'down_point' => 'urganch123',
            'created_at' => "2000-01-01 01:01:01",
            'updated_at' => "2000-01-01 01:01:01"
        ];
    }

    /**
     * Test the schema of unit price table
     */
    public function testUnitPriceSchema()
    {
        $response = $this->json('GET', route('api.unit-prices.index', [1]));
        $response
            ->assertJsonStructure(['*'=>
                    ['shipper_id', 'item_id', 'driver_id', 'type', 'price',
                        'car_type', 'shipper_no', 'stack_point', 'down_point',
                        'delete_flg', 'delete_flg', 'create_id',
                        'update_id', 'created_at', 'updated_at']]
            );
    }

    /**
     * Testing Unit prices creation
     */
    public function testCreateUnitPrices(){
        $response = $this->json('POST', route('api.unit-prices.store'), $this->UnitPrice);
        $response->assertStatus(201);
        $response->assertJsonFragment(
            $this->UnitPrice);
        $unitPriceInDB = UnitPrice::where('stack_point', 'urganch123')
            ->get()->first();
        UnitPrice::where('price_id', $unitPriceInDB->price_id)->delete();
    }




    /**
     * Testing structure of one record
     */
    public function testGetUnitPrices(){
        $unitprices = factory(UnitPrice::class, 1)->create($this->UnitPrice);
        $unitPriceInDB = UnitPrice::where('stack_point', 'urganch123')
            ->get()->first();
        $response = $this->json('GET', route('api.unit-prices.show', [$unitPriceInDB->price_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'shipper_id', 'item_id', 'driver_id', 'type', 'price',
                'car_type', 'shipper_no', 'stack_point', 'down_point',
                'update_id', 'created_at', 'updated_at']);
        UnitPrice::find($unitPriceInDB->price_id)->delete();
    }

    /**
     * Testing the update end point of API
     */
    public function testUpdateUnitPrices(){
        $unit = $this->UnitPrice;
        $unit['car_type'] = 'Wingjon';
        $unitpriceAsArray = factory(UnitPrice::class, 1)->create($unit);
        $unitpriceInDB = UnitPrice::where('car_type', "Wingjon")
            ->get()->first();
        $update_data = [
            'shipper_id' => Shipper::orderBy('shipper_id', 'DESC')->first()->shipper_id,
            'type' => 123,
            'price' => 555,
            'car_type'=>'Cobalt',
            'stack_point' => 'urganch321',
            'down_point' => 'urganch321'];
        $response = $this->json('PUT', route('api.unit-prices.update',[$unitpriceInDB->price_id]),
            $update_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($update_data);
        UnitPrice::where('price_id', $unitpriceInDB->price_id)->delete();
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteUnitPrice(){
        $unitprice = factory(UnitPrice::class)->create($this->UnitPrice);
        $response = $this->json('DELETE',route('api.unit-prices.destroy',[$unitprice->price_id]));
        $response->assertStatus(200);
    }
}
