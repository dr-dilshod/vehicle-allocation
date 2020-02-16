<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\Api\ItemController;
use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ItemApiTest extends TestCase
{

    use WithoutMiddleware;
    private $item;
    public function setUp(): void
    {
        parent::setUp();
        $this->item = [
            'shipper_id'=>1,
            'driver_id'=>1,
            'vehicle_id'=>1,
            'status'=>0,
            'stack_date'=>'2000-01-01',
            'stack_time'=>'10:00:00',
            'down_date'=>'2000-01-01',
            'down_time'=>'20:00:00',
            'down_invoice'=>0,
            'stack_point'=>'StackPointTest',
            'down_point'=>'DownPointTest',
            'weight'=>20,
            'empty_pl'=>1,
            'item_price'=>100,
            'item_driver_name'=>'SomeDriverTest',
            'vehicle_no3'=>'444',
            'shipper_name'=>'SomeTestShipperName',
            'item_vehicle'=>'VehicleTest',
            'vehicle_payment'=>100,
            'item_completion_date'=>'2020-01-01',
            'item_remark'=>'ThisIsTestRemark',
            'remember_token'=>'testRememberToken',
            'created_at' =>'2020-01-01 00:00:00',
            'updated_at'=>'2020-01-01 00:00:00',
        ];
    }

    /**
     * test the database schema for the result of index page
     */
    public function testItemSchema()
    {
        $item = factory(\App\Item::class)->create($this->item);
        $itemInDB = Item::where('item_remark', 'ThisIsTestRemark')
            ->get()->first();
        $response = $this->json('GET', route('api.item.index', [$itemInDB->item_id]));
        $response
             ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['shipper_id', 'driver_id', 'vehicle_id', 'status',
                        'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice',
                        'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price',
                        'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment',
                        'item_completion_date', 'item_remark', 'delete_flg', 'create_id',
                        'created_at', 'update_id', 'updated_at', 'remember_token']
                ]
            ]);
        Item::where('item_id', $itemInDB->item_id)->delete();
    }

    /**
     * Testing item creation
     */
    public function testCreateItem(){
        $itemObject = factory(Item::class)->make($this->item);
        $response = $this->json('POST', route('api.item.store'), $this->item);
        $response->assertStatus(200);
        $response->assertJsonFragment(
            $this->item);
        $itemInDB = Item::where('item_remark', 'ThisIsTestRemark')
            ->get()->first();
        Item::where('item_id', $itemInDB->item_id)->delete();

    }

    /**
     * Testing structure of one record and test getting one record
     */
    public function testGetItem(){
        $item = factory(Item::class)->create($this->item);
        $itemInDB = Item::where('item_remark', 'ThisIsTestRemark')
            ->get()->first();
        $response = $this->json('GET', route('api.item.show', [$itemInDB->item_id]));
        $response->assertStatus(200)
            ->assertJsonFragment($this->item);
        $response->assertSeeText($itemInDB->stack_date);
        $response->assertSeeText($itemInDB->down_date);
        $response->assertSeeText($itemInDB->item_remark);
        $response->assertSeeText($itemInDB->item_driver_name);
        Item::where('item_id', $itemInDB->item_id)->delete();
    }

    /**
     * Testing the update end point of Item API
     */
    public function testUpdateItem() {
        $item = factory(Item::class)->create($this->item);
        $itemInDB = Item::where('item_remark', 'ThisIsTestRemark')
            ->get()->first();
        $update_data = ['status' => 1,
            'stack_point' => 'SecondStackPointTest',
            'down_point' => 'SecondDownPointTest'];
        $response = $this->json('PUT', route('api.item.update',[$itemInDB->item_id]),
            $update_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($update_data);
        Item::where('item_id', $itemInDB->item_id)->delete();
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteItem(){
        $item = factory(Item::class)->create($this->item);
        $response = $this->json('DELETE',route('api.item.destroy',[$item->item_id]));
        $response->assertStatus(204);
    }

    /**
     * Test further endpoints as well in the web.php
     */
}
