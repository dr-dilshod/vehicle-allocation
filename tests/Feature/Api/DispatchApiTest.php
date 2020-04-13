<?php

namespace Tests\Feature\Feature\Api;

use App\Dispatch;
use App\Driver;
use App\Http\Controllers\Api\DispatchController;
use App\Item;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use mysql_xdevapi\Table;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;


/**
 * Class VehicleApiTest
 * @package Tests\Feature\Feature\Api
 * @author Dilshod K
 */
class DispatchApiTest extends TestCase
{
    use WithFaker;
    use WithoutMiddleware;
    private $item;
    private $driver;

    public function setUp(): void
    {
        parent::setUp();
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

    /**
     * Test the schema of dispatch table
     */
    public function testDispatchSchema()
    {
        $response = $this->json('GET', route('api.dispatch.index'));
        $response->assertStatus(200);
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
            'timezone' => 1,
            'create_id' => 1,
            'update_id' => 1
        ]];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $resp = $this->json('POST', route('api.dispatch.store'), $data);
        $resp->assertStatus(201);
        $dispatch = Dispatch::query()->where($data[0]);
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
        $this->assertGreaterThan(0, $dispatch->count());
        $dispatch->delete();
    }
}
