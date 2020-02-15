<?php
/**
 * Created by PhpStorm.
 * User: Bekmurod
 * Date: 13.02.2020
 * Time: 18:56
 */


namespace Tests\Feature\Api;




use App\UnitPrice;
use App\Shipper;
use App\Item;
use Illuminate\Auth\Access\Gate;
use mysql_xdevapi\Table;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;



class UnitPriceApiTest extends TestCase
{

    use WithFaker;
    use WithoutMiddleware;
    private $UnitPrice;

    public function setUp(): void
    {
        parent::setUp();
        $this->UnitPrice= [
            'shipper_id' => Shipper::orderBy('shipper_id', 'DESC')->first()->shipper_id,
            'item_id'=>Item::orderBy('item_id', 'DESC')->first()->item_id,
            'driver_id'=>201,
            'type' => '123',
            'price' => '555',
            'car_type' => 'trailer',
            'shipper_no' => '555',
            'stack_point' => 'Tokio',
            'down_point' => 'Gifu',
            'delete_flg' => '0',
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
        //$unitprices = factory(UnitPrice::class)->create();
        $response = $this->json('POST', route('api.unit-prices.store'), $this->UnitPrice);

        $response->assertStatus(201);
        $this->assertDatabaseHas('unit_prices',[
            'shipper_id' => Shipper::orderBy('shipper_id', 'DESC')->first()->shipper_id,
            'item_id'=>Item::orderBy('item_id', 'DESC')->first()->item_id,
            'driver_id'=>201,
        ]);
        UnitPrice::orderBy('driver_id', 'DESC')->first()->delete();
    }



    /**
     * Testing structure of one record
     */
    public function testGetUnitPrices(){
        $unitprices = factory(UnitPrice::class)->create();
        $response = $this->json('GET', route('api.unit-prices.show', [$unitprices->price_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'shipper_id', 'item_id', 'driver_id', 'type', 'price',
                'car_type', 'shipper_no', 'stack_point', 'down_point',
                'delete_flg', 'create_id',
                'update_id', 'created_at', 'updated_at']);
        UnitPrice::find($unitprices->price_id)->delete();
    }

    /**
     * Testing the update end point of API
     */
    public function testUpdateUnitPrices(){
        $update_data = $this->UnitPrice;
        $update_data['type'] = '5540';
        $new_unitprice = factory(UnitPrice::class)->create($this->UnitPrice);
        $response = $this->json('PUT', route('api.unit-prices.update',[$new_unitprice->price_id]),
            $update_data);
        UnitPrice::find($new_unitprice->price_id)->delete();
        $response->assertStatus(200);
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteUnitPrice(){
        $unitprice = factory(UnitPrice::class)->create($this->UnitPrice);
        $response = $this->json('DELETE',route('api.unit-prices.destroy',[$unitprice->price_id]));
        $response->assertStatus(204);
    }
}
