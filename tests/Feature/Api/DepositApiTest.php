<?php

namespace Tests\Feature\Api;

use App\Deposit;
use App\Driver;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;


class DepositApiTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        $user = Driver::findOrFail(1);

        $response = $this
            ->actingAs($user)
            ->json('GET', route('api.deposit.index'));
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
        $user = Driver::findOrFail(1);
        $deposit = factory(Deposit::class)->make();

        $response = $this
            ->actingAs($user)
            ->json('POST', route('api.deposit.store'),$deposit->toArray());

        $response->assertStatus(201)
                    ->assertJsonStructure([
                        'deposit_id','invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'
                    ]);
    }

    public function testShow(){
        $user = Driver::findOrFail(1);
        $deposit = factory(Deposit::class)->create();

        $response = $this
            ->actingAs($user)
            ->json('GET', route('api.deposit.show', [$deposit->deposit_id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'deposit_id','invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'
            ]);
    }

    public function testUpdate(){
        $user = Driver::findOrFail(1);
        $id = factory(Deposit::class)->create()->deposit_id;
        $deposit = factory(Deposit::class)->make();

        $response = $this
            ->actingAs($user)
            ->json('PUT', route('api.deposit.update',[$id]), $deposit->toArray());

        $response->assertStatus(200);
    }

    public function testDelete(){
        $user = Driver::findOrFail(1);
        $id = factory(Deposit::class)->create()->deposit_id;

        $response = $this
            ->actingAs($user)
            ->json('DELETE',route('api.deposit.destroy',[$id]));

        $response->assertStatus(204);
    }

}
