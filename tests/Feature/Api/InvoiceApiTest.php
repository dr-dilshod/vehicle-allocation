<?php

namespace Tests\Feature\Api;


use App\Invoice;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceApiTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInvoiceSchema()
    {
        $user = Invoice::findOrFail(1);
        $response = $this
            ->actingAs($user)
            ->json('GET', route('api.invoice.index'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'item_id', 'shipper_id', 'vehicle_id', 'create_id', 'update_id', 'billing_recording_date', 'billing_deadline_date', 'payment_record_date', 'invoice_remark', 'delete_flg', 'remember_token', 'created_at', 'updated_at']
            ]);
    }
    /**
     * Testing Driver creation
     */
    public function testCreateInvoice(){

        $invoice = factory(Invoice::class)->make();

        $response = $this->json('POST', route('api.invoice.store'), $invoice->toArray());

        $response->assertStatus(201);
    }
    /**
     * Testing structure of one record
     */
    public function testGetInvoice(){
        $invoice = factory(Invoice::class)->create();
        $response = $this->json('GET', route('api.invoice.show', [$invoice->invoice_id]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'item_id', 'shipper_id', 'vehicle_id', 'create_id', 'update_id', 'billing_recording_date', 'billing_deadline_date', 'payment_record_date', 'invoice_remark', 'delete_flg', 'remember_token', 'created_at', 'updated_at']);
    }
    /**
     * Testing update one record
     */
    public function testUpdateInvoice(){
        $id = factory(Invoice::class)->create()->invoice_id;
        $invoice = factory(Invoice::class)->make();
        $response = $this->json('PUT', route('api.invoice.update',[$id]),
            $invoice->toArray());
        $response->assertStatus(200);
    }
    /**
     * Testing delete one record
     */
    public function testDeleteInvoice(){

        $invoice = factory(Invoice::class)->create();

        $response = $this->json('DELETE',route('api.invoice.destroy',[$invoice->invoice_id]));

        $response->assertStatus(204);
    }
}
