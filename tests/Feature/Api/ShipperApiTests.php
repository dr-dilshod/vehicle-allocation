<?php

use App\Shipper;
use Illuminate\Foundation\Testing\WithoutMiddleware;
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

    public function testPageShippers()
    {
        $response = $this->json('GET', 'api/shipper');
        $response
            ->assertStatus(200)
            ->assertJson([])
            ->assertJsonStructure([
                'data' => [
                    ['id', 'shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code', 'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at']
                ]
            ]);
    }

    public function testCreateShipper(){

        $shipper = factory(Shipper::class)->make();

        $response = $this->json('POST', 'api/shipper', $shipper->toArray());

        $response->assertStatus(201);
    }

    public function testGetShipper(){

        $shipper = factory(Shipper::class)->create();

        $response = $this->json('GET', 'api/shipper/'.$shipper->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code', 'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'
            ]);
    }

    public function testUpdateShipper(){

        $id = factory(Shipper::class)->create()->id;
        $shipper = factory(Shipper::class)->make();
        $shipper->id = $id;

        $response = $this->json('PUT', 'api/shipper/'.$id, $shipper->toArray());

        $response->assertStatus(200);
    }

    public function testDeleteShipper(){

        $shipper = factory(Shipper::class)->create();

        $response = $this->json('DELETE','api/shipper/'.$shipper->id);

        $response->assertStatus(204);
    }

}