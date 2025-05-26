<?php

namespace App\Http\Controllers\payment;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use App\Http\Controllers\Controller;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:my_office_doctors,id',
            'patient_id' => 'required|exists:my_office_patients,id',
            'appointment_id' => 'required|exists:consultations,id',
            'amount' => 'required|numeric|min:1',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'uah',
                        'product_data' => [
                            'name' => 'Консультація лікаря',
                        ],
                        'unit_amount' => intval($request->amount * 100), 
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payments.success', ['appointment_id' => $request->appointment_id]),
                'cancel_url' => route('payments.cancel'),
                'metadata' => [
                    'doctor_id' => $request->doctor_id,
                    'patient_id' => $request->patient_id,
                    'appointment_id' => $request->appointment_id,
                ],
            ]);

            return response()->json(['id' => $session->id]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function paymentSuccess(Request $request)
    {
        
        return view('payments.success');
    }

    public function paymentCancel()
    {
        
        return view('payments.cancel');
    }

    
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); 

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );

            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;

                
                DB::transaction(function () use ($session) {
                    $doctor_id = $session->metadata->doctor_id;
                    $patient_id = $session->metadata->patient_id;
                    $appointment_id = $session->metadata->appointment_id;
                    $amount = $session->amount_total / 100;

                    $payment = Payment::create([
                        'doctor_id' => $doctor_id,
                        'patient_id' => $patient_id,
                        'appointment_id' => $appointment_id,
                        'transaction_amount' => $amount,
                        'status' => 'pending', 
                        'payment_date' => now(),
                    ]);

                    
                });
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Webhook error: ' . $e->getMessage()], 400);
        }
    }

    
    public function releasePayment($appointment_id)
    {
        $payment = Payment::where('appointment_id', $appointment_id)->first();

        if (!$payment) {
            return response()->json(['error' => 'Платіж не знайдено'], 404);
        }

        if ($payment->status === 'released') {
            return response()->json(['message' => 'Кошти вже переведено лікарю.']);
        }

        DB::beginTransaction();

        try {
            
            $payment->status = 'released';
            $payment->save();

            
            Transaction::create([
                'payment_id' => $payment->id,
                'doctor_id' => $payment->doctor_id,
                'patient_id' => $payment->patient_id,
                'amount' => $payment->transaction_amount,
                'transaction_type' => 'release',
                'status' => 'success',
                'description' => 'Виплата лікарю після завершення консультації',
            ]);

            DB::commit();

            return response()->json(['message' => 'Кошти успішно переведено лікарю.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Помилка: ' . $e->getMessage()], 500);
        }
    }
}
