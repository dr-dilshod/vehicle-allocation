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
    private $payment;
    use WithFaker;
    public function setUp(): void
    {

        parent::setUp();
        $test_data = [
            'payment_day' => date('Y-m-d'),
            'payment_amount' => 888888888,
            'other' => 888888888,
            'fee' => 888888888,
            'delete_flg' => 0
        ];
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($test_data));
        $vehicleController = new PaymentController();
        $fetch = $vehicleController->store($request);
    }
    public function testIndex()
    {
        $response = $this->get(route('api.payment.index'));
        $response->assertSeeText('888888888');
        $response->assertSeeText('888888888');
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $test_data = [
            'payment_day' => Carbon::today('Y-m-d'),
            'payment_amount' => 9999999999,
            'other' => 9999999999,
        ];
        $response = $this->post(route('api.payment.store'), $test_data);
        $this->assertDatabaseHas('payments', [
            'payment_day' => Carbon::today('Y-m-d'),
            'payment_amount' => 9999999999,
            'other'=>9999999999
        ]);
        $response = $this->get(route('api.payment.index'));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $test_data = [
            'payment_day' => Carbon::today('Y-m-d'),
            'payment_amount' => 9999999999,
            'other' => 9999999999,
        ];
        $response = $this->put(route('api.payment.update', ['payment_id' => $this->payment->id]), $test_data);
        $this->assertDatabaseHas('payments', [
            'payment_day' => Carbon::today('Y-m-d'),
            'payment_amount' => 9999999999,
            'other' => 9999999999,
        ]);
        $response = $this->get(route('api.payment.index'));
        $response->assertSeeText('9999999999');
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $response = $this->delete(route('api.payment.destroy', ['payment_id' => $this->payment->payment_id]));
        $this->assertSoftDeleted('payments', [
            'payment_day' => Carbon::today('Y-m-d'),
            'payment_amount' => 9999999999,
            'other' => 9999999999,
        ]);
    }
    public function testSearch()
    {
        $response = $this->get(route('api.payment.show', ['payment_id' => $this->payment->payment_id]));
        $response->assertStatus(200);
        $response->assertSeeText($this->payment->payment_amount);
        $response->assertSeeText($this->payment->other);
        $response->assertSeeText($this->user->fee);
        $response->assertSeeText($this->user->payment_day);
    }
}
