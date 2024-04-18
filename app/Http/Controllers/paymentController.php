<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\Transactions;
use DB;
use Carbon\Carbon;
use Stripe;
use Validator;
use Session;
use Illuminate\Support\Facades\Http;
use stdClass;



class paymentController extends Controller
{
    public function index($userId, $planId)
    {
        // return $data = [$userId, $planId];
        $plan = DB::table('plans')->where('id', $planId)->get(['name as planName', 'price as planPrice']);
        $user = DB::table('tbl_users')->where('id', $userId)->get('name as userName');
        
        return view('admin.payment.index', ['userId' => $userId, 'planId' => $planId, 'plan'=>$plan, 'user'=>$user]);
    }

    public function payment_form($userId, $planId)
    {
        $plan = DB::table('plans')->where('id', $planId)->get(['name as planName', 'price as planPrice']);
        $user = DB::table('tbl_users')->where('id', $userId)->get('name as userName');
        //return ['plan' => $plan, 'user' => $user ];
        
        return view('admin.payment.form', ['userId' => $userId, 'planId' => $planId, 'plan'=>$plan, 'user'=>$user]);
    }

    public function post_payment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "stripeToken" => "required"
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $planId = $request->planId;
        $userId = $request->userId;

        $stripeToken = $request->stripeToken;

        $plan = DB::table('plans')->where('id', $planId)->get(['price','name']);
        // $price = $plan[0]->price;
        $price = 2;
        $planName = $plan[0]->name;
        $user = DB::table('tbl_users')->where('id', $userId)->get('name as userName');
        $userDet = $user[0]->userName;

        $expiry_year = (int)$request->exp_year;

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $stripe_client = $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        
         $method= \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
              'number' => $request->card_number,
              'exp_month' => $request->exp_month,
              'exp_year' => $expiry_year,
              'cvc' => $request->cvc,
            ],
          ]);

        //   return $method;
        $transactionId = \Str::random(18);
        $pay = Stripe\PaymentIntent::create([
                    // 'amount'=>$price*100,
                    'amount'=>1*100,
                    'currency' => 'inr',
                    'payment_method_types' => ['card'],
                    'payment_method' => $method->id,
                    'description' =>$userDet." bought ". $planName,
                    "confirm" => true,
                    "return_url" => route('stripeResponse', ['transactionId' => $transactionId]),
                    "payment_method_options[card][request_three_d_secure]" => "automatic",
                ]);
        
            //  return $pay;   
        /**
         * for 3ds enabled card
         * */        
        // $redirectUrl = $pay->next_action->redirect_to_url->url;
        if(isset($pay->next_action->redirect_to_url->url) && $pay->next_action->redirect_to_url->url != NULL) {
            
            
        /**
         * store payment details in Table
         */
            $newTransaction = new Transactions;
            $newTransaction->userId = $userId;
            $newTransaction->planId = $planId;
            $newTransaction->transactionId = $transactionId;
            $newTransaction->status = $pay->status;
            $newTransaction->charge = $pay->amount/100;
            $newTransaction->save();
            
            
            return redirect()->away($pay->next_action->redirect_to_url->url);
        } 
       
        // for cards without 3ds
        elseif( isset($pay->status) && $pay->status == 'succeeded' ){
            
            /**
             * store payment details in Table
             */
            $newTransaction = new Transactions;
            $newTransaction->userId = $userId;
            $newTransaction->planId = $planId;
            $newTransaction->transactionId = $transactionId;
            $newTransaction->charge = $pay->amount/100;
            $newTransaction->status = $pay->status;
            $newTransaction->save();

            DB::table('tbl_users')->where('id', $userId)->update([
                "payment_status"=> 1,
                "plan"=>$planId
            ]);

            $check_validity=Plan::where('id',$planId)->first();

            $valid_upto=Carbon::now()->addMonth($check_validity->validity)->toDateTimeString();
                
            DB::table('plan_history')->where('user_id',$userId)->insert([
                'user_id'=>$userId,
                'plan_id'=>$planId,
                'isActive'=>1,
                'isCancelled'=>0,
                'valid_upto'=>$valid_upto,
            ]);
            
            return redirect()->route('stripeResponse',['transactionId' => $transactionId,'payment_intent' => $pay->id])->with('message','Payment Succesful');
        } 
        //payment error
        elseif(isset($pay->error->message) && $pay->error->message != NULL) {

            /**
             * store payment details in Table
             */
            $newTransaction = new Transactions;
            $newTransaction->userId = $userId;
            $newTransaction->planId = $planId;
            $newTransaction->transactionId = $transactionId;
            $newTransaction->status = $pay->error->message;
            $newTransaction->charge = $pay->amount/100;

            $newTransaction->save();

            return redirect()->route('stripeResponse',['transactionId' => $transactionId,'payment_intent' => $pay->id])->with('message',$pay->error->message);
        } 
        else {

             /**
             * store payment details in Table
             */
            $newTransaction = new Transactions;
            $newTransaction->userId = $userId;
            $newTransaction->planId = $planId;
            $newTransaction->transactionId = $transactionId;
            $newTransaction->status = $pay->error->message;
            $newTransaction->charge = $pay->amount/100;

            $newTransaction->save();
            
            return redirect()->route('stripeResponse',['transactionId' => $transactionId,'payment_intent' => $pay->id])->with('message','Something Went Wrong. Please try Again');
        } 
            
        

                
        /*
        if($pay) {
            DB::table('tbl_users')->where('id', $userId)->update([
                "payment_status"=> 1,
                "plan"=>$planId
            ]);

            $check_validity=Plan::where('id',$planId)->first();

            $valid_upto=Carbon::now()->addMonth($check_validity->validity)->toDateTimeString();
                
            DB::table('plan_history')->where('user_id',$userId)->insert([

                'user_id'=>$userId,
                'plan_id'=>$planId,
                'isActive'=>1,
                'isCancelled'=>0,
                'valid_upto'=>$valid_upto,

            ]);
            return view('admin.payment.success');


        } 
        
        else {
            return view('admin.payment.fail');
        }
        */

    }
	
    public function response(Request $request)
    {
        // return $request->all();


        /**
         * get userid and planid
         */

        $getData = DB::table('transactions')->where('transactionId', $request->transactionId)->get(['userId','planId']);
        // return $getData;

        /**
         * get payment status
         * by payment intent
         */

        $url = "https://api.stripe.com/v1/payment_intents/".$request->payment_intent;
        $apiCall = Http::withHeaders([
            'Authorization' => 'Bearer '.env('STRIPE_SECRET_KEY'),
        ])->get($url);
        $data = $apiCall->json();

        // return $data;

        if($apiCall->status() != 200) {
            return view('admin.payment.fail');
        }



        //save card details if payment authentication is failed
        if(isset($data['last_payment_error']) && $data['last_payment_error'] != NULL) {
            
            $cardDetails = new stdClass;
            $cardDetails->brand = $data['last_payment_error']['payment_method']['card']['brand'];
            $cardDetails->type = $data['last_payment_error']['payment_method']['type'];
            $cardDetails->lastFourDigits = $data['last_payment_error']['payment_method']['card']['last4'];
            // return $cardDetails;

        } else {
            
            //save card details when payment is success
            $cardDetails = new stdClass;
            $cardDetails->type = $data['charges']['data'][0]['payment_method_details']['type'];
            $cardDetails->brand = $data['charges']['data'][0]['payment_method_details']['card']['brand'];
            $cardDetails->lastFourDigits = $data['charges']['data'][0]['payment_method_details']['card']['last4'];

        }

        // return $cardDetails;

        $cardId = NULL;
        $checkCardExist = DB::table('saved_card')->where('lastFourDigits', $cardDetails->lastFourDigits)->exists();
        if(!$checkCardExist) {
            $save = DB::table('saved_card')->insertGetId([
                "brand" => $cardDetails->brand,
                "type" => $cardDetails->type,
                "lastFourDigits" => $cardDetails->lastFourDigits,
            ]);

            $cardId = $save;

        } else {
            $savedCard = DB::table('saved_card')->where('lastFourDigits', $cardDetails->lastFourDigits)->pluck('id');
            $cardId = $savedCard[0];
        }

        // return $cardId;

        if(isset($data['status']) && $data['status'] == 'succeeded' ){
            // payment_method_details
            $finalData = new stdClass;
            $finalData->amount = $data['charges']['data'][0]['amount_captured']/100;
            $finalData->description = $data['description'];
            $finalData->cardDetails = $cardDetails;
            // return $finalData;
            //3d card verified

            DB::table('transactions')->where('transactionId',$request->transactionId)->update([
                "status" => $data['status'],
                "description" => $finalData->description,
                "cardUsed" => $cardId,
                // "charge" => $finalData->amount
            ]);


            //update plan for user
            DB::table('tbl_users')->where('id', $getData[0]->userId)->update([
                "payment_status"=> 1,
                "plan"=>$getData[0]->planId
            ]);

            $check_validity=Plan::where('id',$getData[0]->planId)->first();

            $valid_upto=Carbon::now()->addMonth($check_validity->validity)->toDateTimeString();
                
            DB::table('plan_history')->where('user_id', $getData[0]->userId)->insert([
                'user_id'=>$getData[0]->userId,
                'plan_id'=>$getData[0]->planId,
                'isActive'=>1,
                'isCancelled'=>0,
                'valid_upto'=>$valid_upto,
            ]);


            return view('admin.payment.success',["data" => $finalData]);
        } else {

            //3d card not verrified
            DB::table('transactions')->where('transactionId',$request->transactionId)->update([
                "status" => $data['status'],
                "cardUsed" => $cardId,
                "description" => $data['description']
                // "charge" => 
            ]);

            return view('admin.payment.fail',["data" => ['transactionId' => $request->transactionId, 'message' => 'Payment Failed']]);
        }

    }


    public function transactions()
    {
        $data = DB::table('transactions')
                ->join('tbl_users','transactions.userId','=','tbl_users.id')
                ->join('plans','transactions.planId','=','plans.id')
                // ->join('saved_card','transactions.cardUsed','=','saved_card.id')
                ->get(['transactions.*', 'tbl_users.name as userName','plans.name as planName']);
        // return $data;                
        return view('admin.transactions.index',['data' => $data]);                
    }

    public function transactions_details($txnId)
    {
        $exists =DB::table('transactions')
                ->where('transactionId', $txnId)
                ->exists();
                
        if(!$exists) {
            return redirect()->route('transactions')->with('message','Invalid Transaction ID');
        } 
                

        $data = DB::table('transactions')
                ->where('transactionId', $txnId)
                ->join('tbl_users','transactions.userId','=','tbl_users.id')
                ->join('plans','transactions.planId','=','plans.id')
                ->join('saved_card','transactions.cardUsed','=','saved_card.id')
                ->get(['transactions.*', 'tbl_users.name as userName','plans.name as planName','saved_card.brand','saved_card.lastFourDigits','saved_card.type']);
        
        $stripeCharge = 0.02;
        $overallAmount = $data[0]->charge - 0.02*$data[0]->charge;                
        $data[0]->overallAmount = $overallAmount;

        // return $data;

        return view('admin.transactions.view', ['data' => $data]);
    }




	public function webhook(Request $request)
    {
		
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'whsec_3HzCa8eicF4rr5b6mQqgPH1wjEtrBBvE';
		
		
		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
        $event = Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
			$myfile = fopen(public_path("logs.txt"), "w");
			fwrite($myfile, $event);
			fclose($myfile);
        } catch(\UnexpectedValueException $e) {
			// Invalid payload
			$myfile = fopen(public_path("logs.txt"), "w");
			fwrite($myfile, $e);
			fclose($myfile);
			http_response_code(400);
			exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signature
			$myfile = fopen(public_path("logs.txt"), "w");
			fwrite($myfile, $e);
			fclose($myfile);
			http_response_code(400);
			exit();
        }

        // Handle the event
        $text = 'Received unknown event type ' . $event->type;
		$myfile = fopen(public_path("logs.txt"), "w");
        fwrite($myfile, $text);
        fclose($myfile);
        http_response_code(200);
    }
	
}
