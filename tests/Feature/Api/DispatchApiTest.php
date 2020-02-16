<?php

namespace Tests\Feature\Feature\Api;

use App\Dispatch;
use App\Driver;
use App\Item;
use Illuminate\Auth\Access\Gate;
use mysql_xdevapi\Table;
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
    private $dispatch;

    public function setUp(): void
    {
        parent::setUp();
        $this->dispatch = [
            'driver_id'=>Driver::orderBy('driver_id', 'DESC')->first()->driver_id,
            'item_id'=>Item::orderBy('item_id', 'DESC')->first()->item_id,
            'timezone'=>1,
            'delete_flg'=>'0',
            'create_id'=>'2',
            'update_id'=>'2',
            'created_at'=>"2000-01-01 01:01:01",
            'updated_at'=>"2000-01-01 01:01:01"];
    }

    /**
     * Test the schema of dispatch table
     */
    public function testDispatchSchema()
    {
        $response = $this->json('GET', route('api.dispatch.index'));
        $response->assertStatus(200);
    }
}
