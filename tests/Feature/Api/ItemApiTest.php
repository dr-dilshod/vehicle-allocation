<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Controllers\Api\ItemController;
use App\Item;

class ItemApiTest extends \PHPUnit_Framework_TestCase
{

    public function testShow()
    {

    }

    public function testStore()
    {

    }

    public function testDestroy()
    {

    }

    public function testIndex()
    {

    }

    public function testUpdate()
    {

    }

    use WithoutMiddleware;

    public function testItemRegistrationPage()
    {
        $response = $this->json('GET', 'api/item');
        $response
            ->assertStatus(200)
            ->assertJson([])
            ->assertJsonStructure([
                'data' => [
                    ['shipper_id', 'driver_id', 'vehicle_no', 'status',
                        'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice',
                        'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price',
                        'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment',
                        'item_completion_date', 'item_remark', 'delete_flg', 'create_id',
                        'created_at', 'update_id', 'updated_at', 'remember_token']
                ]
            ]);
    }

    public function testCreateItem(){

        $item = factory(Item::class)->make();
        $response = $this->json('POST', 'api/item', $item->toArray());
        $response->assertStatus(201);
    }

    public function testGetItem(){
        $item = factory(Item::class)->create();
        $response = $this->json('GET', route('api.item.show', [$item->item_id]));
        $response->assertStatus(200)
            ->assertJsonStructure(['shipper_id', 'driver_id', 'vehicle_no', 'status',
                'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice',
                'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price',
                'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment',
                'item_completion_date', 'item_remark', 'delete_flg', 'create_id',
                'created_at', 'update_id', 'updated_at', 'remember_token']);
    }

    public function testUpdateItem(){

        $id = factory(Item::class)->create()->item_id;
        $item = factory(Item::class)->make();
        $response = $this->json('PUT', route('api.item.update',[$id]), $item->toArray());
        $response->assertStatus(200);
    }

    public function testDeleteItem(){
        $item = factory(Item::class)->create();
        $response = $this->json('DELETE',route('api.item.destroy',[$item->item_id]));
        $response->assertStatus(204);
    }

}
