<?php

namespace Tests\Feature\Api;

use App\Deposit;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;


class DepositApiTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        $response = $this->json('GET', route('api.deposit.index'));
        $response
            ->assertStatus(200)
            ->assertJson([])
            ->assertJsonStructure([
                'data' => [
                    ['deposit_id','invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function testCreate(){

        $deposit = factory(Deposit::class)->make();

        $response = $this->json('POST', route('api.deposit.store'),
            $deposit->toArray());

        $response->assertStatus(201)
                    ->assertJsonStructure([
                        'deposit_id','invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'
                    ]);
    }

    public function testShow(){

        $deposit = factory(Deposit::class)->create();

        $response = $this->json('GET', route('api.deposit.show', [$deposit->deposit_id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'deposit_id','invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'
            ]);
    }

    public function testUpdate(){

        $id = factory(Deposit::class)->create()->deposit_id;
        $deposit = factory(Deposit::class)->make();

        $response = $this->json('PUT', route('api.deposit.update',[$id]), $deposit->toArray());

        $response->assertStatus(200);
    }

    public function testDelete(){

        $id = factory(Deposit::class)->create()->deposit_id;

        $response = $this->json('DELETE',route('api.deposit.destroy',[$id]));

        $response->assertStatus(204);
    }

}
