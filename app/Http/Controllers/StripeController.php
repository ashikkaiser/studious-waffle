<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe;

class StripeController extends Controller
{

    function stripePost(Request $request)
    {
        $st = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );

        $user = User::where('email', $request->token['email'])->first();
        if ($user) {
            $cus_id = $user->stripe_id;
        } else {
            if (session('customer_id')) {
                $cus_id = session('customer_id');
            } else {
                $customer = $stripe->customers->create([
                    'email' => $request->token['email'],
                    'name' => session('step1')['business_name'],
                    'phone' => session('step1')['business_phone'],
                    'address' => [
                        'line1' => session('step3')['business_address1'],
                        'line2' => session('step3')['business_address2'],
                        'city' => session('step3')['business_town'],
                        'country' => session('step3')['business_country'],
                        'postal_code' => session('step3')['business_postal_code'],
                    ],
                ]);

                $cus_id = $customer['id'];
            }
        }




        try {
            $xx =  \Stripe\Customer::createSource(
                $cus_id,
                ['source' => $request->token['id']]
            );

            $payment = json_encode(Stripe\Charge::create([
                "amount" => round($request->amount * 100),
                'customer' => $cus_id,
                "currency" => "gbp",
                "source" => $xx->id,
            ]));
            if ($user) {
                return $this->complete($user, $payment, $request->amount);
            } else {
                $transaction = new Transaction();
                $transaction->company_id = 0;
                $transaction->transaction_id = json_decode($payment)->id;
                $transaction->receipt_url = json_decode($payment)->receipt_url;
                $transaction->email = $request->token['email'];
                $transaction->phone = session('step1')['business_phone'];
                $transaction->name = session('step1')['business_name'];
                $transaction->amount = $request->amount;
                $transaction->others = $payment;
                $transaction->save();

                session()->put('transaction', $transaction->id);
                session()->put('customer_id', $cus_id);
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful',

                ]);
            }
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getError()->message,
            ]);
        }
    }


    function complete($data, $payment, $amount)
    {


        $company = CompanyProfile::where('user_id', $data->id)->first();
        $transaction = new Transaction();
        $transaction->company_id = $company->id;
        $transaction->transaction_id = json_decode($payment)->id;
        $transaction->receipt_url = json_decode($payment)->receipt_url;
        $transaction->email = $data->email;
        $transaction->phone = $company->business_phone;
        $transaction->name = $company->business_name;
        $transaction->amount = $amount;
        $transaction->others = $payment;
        $transaction->save();
        $company->credit = $company->credit + ($amount * site()->credit_conversion);
        $company->save();
        return response()->json([
            'success' => true,
            'message' => 'Payment successful',
        ]);


        // $ev = Events::find($data->event_id);
        // $event = new EventUser();
        // $event->event_id = $data->event_id;
        // $event->name = $data->first_name . " " . $data->last_name;
        // $event->email = $data->email;
        // $event->paid_amount = $data->amount;
        // $event->paid_for = json_decode($ev->price_type)[$data->key];
        // $event->stripe_id = json_decode($payment)->id;
        // $event->receipt_url = json_decode($payment)->receipt_url;
        // $event->save();

        // $maildata = [
        //     'title' => 'You Just Received A new Payment',
        //     'name' =>  $event->name,
        //     'email' => $event->email,
        //     'amount' => $event->paid_amount,
        //     'url' => $event->receipt_url,
        //     'event' => $ev->name,
        //     'paid_for' => json_decode($ev->price_type)[$data->key],
        // ];


        // dispatch(new SendEmailJob($maildata));


    }
}
