<?php


namespace Tests\Unit;


use App\Dispatch;
use App\Driver;
use App\Http\Controllers\Api\DispatchController;
use App\Item;
use Illuminate\Http\Request;
use Schema;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class DispatchTest extends TestCase
{
    private $item;
    private $driver;



    public function setUp(): void
    {
        parent::setUp();
        $this->item = Item::query();
        if ($this->item->count() > 0) {
            $this->item = $this->item->inRandomOrder()->first();
        } else {
            $this->item = factory(Item::class, 1)->create();
        }

        $this->driver = Driver::query()->where('admin_flg', 0);
        if ($this->driver->count() > 0) {
            $this->driver = $this->driver->first();
        } else {
            $this->driver = factory(Driver::class, 1);
        }
    }

    public function testDispatchesTableCoulmns()
    {
        $this->assertTrue(
            Schema::hasColumns('dispatches', [
                'dispatch_id',
                'driver_id',
                'item_id',
                'timezone',
                'delete_flg',
                'create_id',
                'update_id',
                'created_at',
                'updated_at',
            ]), 1);
    }

    public function testCreateDispatch()
    {
        $data = [[
            'driver_id' => $this->driver->driver_id,
            'item_id' => $this->item->item_id,
            'timezone' => 1
        ]];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $controller = new DispatchController();
        $controller->store($request);
        $admin  =  Driver::where('driver_no', 1)->first();
        $this->post(route('api.dispatch.store'), $data);
        $dispatch = Dispatch::where($data);
        $this->assertEquals(1, $dispatch->count());
    }

    public function testDeleteDispatch()
    {
        $data = [
            'driver_id' => $this->driver->driver_id,
            'item_id' => $this->item->item_id,
            'timezone' => 1,
            'create_id' => 1,
            'update_id' => 1
        ];
        $dispatch = Dispatch::create($data);

        $controller = new DispatchController();
        $controller->destroy($dispatch->item_id);
        $dispatch = Dispatch::query()->where($data)->where('delete_flg', 1);
        $this->assertEquals(1, $dispatch->count());
    }
}
