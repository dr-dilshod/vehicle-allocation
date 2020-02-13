<?php

namespace Tests\Feature\Api;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Middleware\Authenticate;
use App\Payment;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class PaymentApiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    use WithFaker;

    /**
     * test the database schema for the result of index page
     */
    public function testPaymentSchema()
    {
        $payment = factory(\App\Payment::class, 1)->create();
        $response = $this->json('GET', route('api.payment.index', [$payment->payment_id]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['shipper_id', 'payment_day', 'payment_amount', 'other',
                        'fee', 'delete_flg', 'create_id', 'update_id', 'created_at', 'updated_at']
                ]
            ]);
        Payment::where('payment_id', $payment->payment_id)->delete();
    }

    /**
     * Testing payment creation
     */
    public function testCreatePayment(){
        $paymentAsArray = factory(Payment::class, 1)->raw();
        $response = $this->json('POST', route('api.payment.store'), $paymentAsArray);
        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', $paymentAsArray);
        Shipper::where('payment_id', $paymentAsArray)->delete();
    }

    /**
     * Testing structure of one record and test getting one record
     */
    public function testGetPayment(){
        $paymentAsArray = factory(Payment::class, 1)->raw();
        $payment = factory(Payment::class, 1)->create($paymentAsArray);
        $response = $this->json('GET', route('api.payment.show', [$payment->payment_id]));
        $response->assertStatus(200)
            ->assertJsonFragment($paymentAsArray);
        $response->assertSeeText($paymentAsArray->payment_amount);
        $response->assertSeeText($paymentAsArray->other);
        $response->assertSeeText($paymentAsArray->fee);
        $response->assertSeeText($paymentAsArray->payment_day);
    }

    /**
     * Testing the update end point of Payment API
     */
    public function testUpdatePayment() {
        $paymentAsArray = factory(Payment::class, 1)->raw();
        $update_data = ['payment_day'=>'2020-02-02 00:00:00',
            'payment_amount'=>2001,
            'other'=>1001,
            'fee'=>1001];
        $new_payment = factory(Payment::class)->create($paymentAsArray);
        $response = $this->json('PUT', route('api.payment.update',[$new_payment->payment_id]),
            $update_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $update_data);
        Payment::where('payment_id', $paymentAsArray->payment_id)->delete();
    }


    /**
     * Testing the delete end point of API
     */
    public function testDeletePayment(){

        $payment = factory(Payment::class, 1)->create();
        $response = $this->json('DELETE',route('api.payment.destroy',[$payment->payment_id]));
        $response->assertStatus(204);
        $res = Payment::where('payment_id', $payment->payment_id)
            ->count();
        self::assertEquals(0, $res);
    }

}
