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
            'stack_date'=>'2020-01-01 00:00:00',
            'stack_time'=>'10:00:00',
            'down_date'=>'2020-01-01 00:00:00',
            'down_time'=>'20:00:00',
            'down_invoice'=>1,
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
            'item_completion_date'=>'2020-01-01 00:00:00',
            'item_remark'=>'RemarkTest',
            'delete_flg'=>0,
            'create_id'=>1,
            'update_id'=>1,
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
        $response = $this->json('GET', route('api.item.index', [1]));
        $response
            ->assertStatus(200)
            ->assertJson([])
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
    }

    /**
     * Testing item creation
     */
    public function testCreateItem(){
        $itemObject = factory(Item::class)->make($this->item);
        $response = $this->json('POST', route('api.item.store'), $itemObject);
        $response->assertStatus(201);
        $this->assertDatabaseHas('items', $itemObject);
        Item::where('item_id', $itemObject->item_id);
    }

    /**
     * Testing structure of one record and test getting one record
     */
    public function testGetItem(){
        $item = factory(Item::class)->create($this->item);
        $response = $this->json('GET', route('api.item.show', [$item->item_id]));
        $response->assertStatus(200)
            ->assertJsonStructure(['shipper_id', 'driver_id', 'vehicle_id', 'status',
                'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice',
                'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price',
                'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment',
                'item_completion_date', 'item_remark', 'delete_flg', 'create_id',
                'created_at', 'update_id', 'updated_at', 'remember_token']);
        $response->assertJsonFragment($item);
    }

    /**
     * Testing the update end point of Item API
     */
    public function testUpdateShipper() {
        $update_data = ['status' => 1,
            'stack_point' => 'SecondStackPointTest',
            'down_point' => 'SecondDownPointTest'];
        $new_item = factory(Item::class)->create($this->item);
        $response = $this->json('PUT', route('api.item.update',[$new_item]),
            $update_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('item', $update_data);
        Shipper::where('stack_point', 'SecondStackPointTest')->delete();
    }

    /**
     * Testing the delete end point of API
     */
    public function testDeleteItem(){
        $item = factory(Item::class)->create($this->shipper);
        $response = $this->json('DELETE',route('api.item.destroy',[$item->item_id]));
        $response->assertStatus(204);
    }

    /**
     * Test further endpoints as well in the web.php
     */
}
