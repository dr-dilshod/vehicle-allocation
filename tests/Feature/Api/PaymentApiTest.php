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
    use WithoutMiddleware;
    use WithFaker;
    private $payment;
    public function setUp(): void
    {
        parent::setUp();
        $this->payment = [
            'shipper_id'=>2,
            'payment_day' => "2000-01-01 01:01:01",
            "payment_amount" => 3000,
            'other' => 3000,
            'fee' => 3000,
            'delete_flg' => 0,
            'created_at' => "2000-01-01 01:01:01",
            'updated_at' => "2000-01-01 01:01:01"

        ];
    }
    /**
     * test the database schema for the result of index page
     */
    public function testPaymentSchema()
    {
        $payment = factory(\App\Payment::class)->create($this->payment);
        $paymentInDB = Payment::where('payment_day', '2000-01-01 01:01:01')
            ->get()->first();
        $response = $this->json('GET', route('payment.search', [$paymentInDB->payment_id]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['shipper_id', 'payment_day', 'payment_amount', 'other',
                        'fee', 'delete_flg', 'create_id', 'update_id', 'created_at', 'updated_at']
                ]
            ]);
        Payment::where('payment_id', $paymentInDB->payment_id)->delete();
    }

    /**
     * Testing payment creation
     */
    public function testCreatePayment(){
        $response = $this->json('POST', route('api.payment.store'), $this->payment);
        $response->assertStatus(201);
        $response->assertJsonFragment(
            $this->payment);
        $paymentInDB = Payment::where('payment_day', '2000-01-01 01:01:01')
            ->get()->first();
        Payment::where('payment_id', $paymentInDB->payment_id)->delete();
    }

    /**
     * Testing structure of one record and test getting one record
     */
    public function testGetPayment(){
        $payment = factory(Payment::class)->create($this->payment);
        $paymentInDB = Payment::where('payment_day', '2000-01-01 01:01:01')
            ->where('created_at', "2000-01-01 01:01:01")
            ->where('updated_at', "2000-01-01 01:01:01")
            ->get()->first();
        $response = $this->json('GET', route('api.payment.show', [$paymentInDB->payment_id]));
        $response->assertStatus(200)
            ->assertJsonFragment($this->payment);
        $response->assertSeeText($paymentInDB->payment_amount);
        $response->assertSeeText($paymentInDB->other);
        $response->assertSeeText($paymentInDB->fee);
        $response->assertSeeText($paymentInDB->payment_day);
        Payment::where('payment_id', $paymentInDB->payment_id)->delete();
    }

    /**
     * Testing the update end point of Payment API
     */
    public function testUpdatePayment() {
        $paymentAsArray = factory(Payment::class)->create($this->payment);
        $paymentInDB = Payment::where('payment_day', '2000-01-01 01:01:01')
            ->where('created_at', "2000-01-01 01:01:01")
            ->where('updated_at', "2000-01-01 01:01:01")
            ->get()->first();
        $update_data = ['shipper_id'=>2,
            'payment_day'=>'2020-02-02 00:00:00',
            'payment_amount'=>2001,
            'other'=>1001,
            'fee'=>1001];
        $response = $this->json('PUT', route('api.payment.update',[$paymentInDB->payment_id]),
            $update_data);
        $response->assertStatus(200);
        $response->assertJsonFragment($update_data);
        Payment::where('payment_id', $paymentInDB->payment_id)->delete();
    }


    /**
     * Testing the delete end point of API
     */
    public function testDeletePayment(){
        $payment = factory(Payment::class, 1)->create($this->payment);
        $paymentInDB = Payment::where('payment_day', '2000-01-01 01:01:01')
            ->where('created_at', "2000-01-01 01:01:01")
            ->where('updated_at', "2000-01-01 01:01:01")
            ->get()->first();

        $response = $this->json('DELETE',route('api.payment.destroy',[$paymentInDB->payment_id]));
        $response->assertStatus(204);
        $res = Payment::where('payment_id', $paymentInDB->payment_id)
            ->where('delete_flg', 0)
            ->count();
        self::assertEquals(0, $res);
    }

}
