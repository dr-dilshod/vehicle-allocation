<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\UnitPriceController;
use App\UnitPrice;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class UnitPriceTest extends TestCase
{
    public function testTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('unit_prices', [
                'price_id',
                'shipper_id',
                'item_id',
                'driver_id',
                'type',
                'price',
                'delete_flg',
                'create_id',
                'update_id',
                'created_at',
                'updated_at'
            ]), 'OK');
    }


    public function testCreateUnitPrice()
    {
        //For the tests to work fully, the shipper, driver and items
        // must be available in their tables according to the ID below
        $testData = [
            'shipper_id' => 1,
            'driver_id' => 1,
            'item_id' => 1,
            'type' => 1,
            'price' => 100
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($testData));
        $unitPriceController = new UnitPriceController();
        $store = $unitPriceController->store($request);
        $count = UnitPrice::where([
                'shipper_id' => $testData['shipper_id'],
                'driver_id' => $testData['driver_id'],
                'item_id' => $testData['item_id']]
        )->count();
        $this->assertTrue($count > 0, 'OK');
    }

    public function testUpdateUnitPrice()
    {
        //For the tests to work fully, the shipper, driver and items
        // must be available in their tables according to the ID below
        $testData = [
            'shipper_id' => 1,
            'driver_id' => 1,
            'item_id' => 1,
            'type' => 1,
            'price' => 1300
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($testData));
        $unitPriceController = new UnitPriceController();
        $store = $unitPriceController->update($request, 24);
        $unitPrice = UnitPrice::where([
                'shipper_id' => $testData['shipper_id'],
                'driver_id' => $testData['driver_id'],
                'item_id' => $testData['item_id']]
        )->first();
        $this->assertEquals(1300, $unitPrice->price, 'OK');
    }

    public function testDeleteUnitPrice()
    {
        $unitPrice = new UnitPrice();
        $unitPrice->setRawAttributes([
            'shipper_id' => 12,
            'item_id' => 4,
            'driver_id' => 11,
            'type' => 2,
            'price' => 2
        ]);
        $unitPrice->save();
        $controller = new UnitPriceController();
        $controller->destroy($unitPrice->price_id);
        $count = UnitPrice::where([
            'shipper_id' => 12,
            'item_id' => 4,
            'driver_id' => 11,
            'delete_flg' => 0
        ])->count();
        $this->assertEquals(0, $count);
    }

}
