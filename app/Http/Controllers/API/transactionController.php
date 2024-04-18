<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Transactions;
use App\Models\Plan;
use Carbon\Carbon;
use Validator;

class transactionController extends Controller
{
    public function insert_payment(Request $request)
    {
        // $validate = Validator::make($request->all(), [
        //     'transactionId' : 'unique:transactions'
        // ]);
     
        $planId = $request->planId;
        $userId = $request->userId;
        $price = $request->price;
        $description = $request->description;
        $status = $request->status;
        $transactionId = $request->transactionId;
        
        $checkCardExist = DB::table('saved_card')->where('lastFourDigits', $request->lastFourDigits)->exists();
        if(!$checkCardExist) {    
            $save = DB::table('saved_card')->insertGetId([
                "brand" => $request->brand,
                "type" => $request->type,
                "lastFourDigits" => $request->lastFourDigits,
            ]);
        } else {
            $cardId = DB::table('saved_card')->where('lastFourDigits', $request->lastFourDigits)->pluck('id');
            $save = $cardId[0];
        }
        

        if($status == 'succeeded') {
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
        }

        $insert = new Transactions;
        $insert->userId = $userId;
        $insert->planId = $planId;
        $insert->transactionId = $transactionId;
        $insert->description = $description;
        $insert->cardUsed = $save;
        $insert->status = $status;
        $insert->charge = $price;
        
        
        
        if($insert->save()) {
            return response()->json([
                "response_code" => 200,
                "response_message" => "Transaction detail saved"
            ]);
        } else {
            return response()->json([
                "response_code" => 401,
                "response_message" => "Oops! Some error occured!"
            ]);
        }

    }
}
