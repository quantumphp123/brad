<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use DB;
use Hash;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    //

    public function apple_callback(Request $request)
    {
        return $request;
    }

    public function Glogin(Request $request)
    {
		
        
            // $url = "https://www.googleapis.com/oauth2/v3/userinfo";
            /*
            Android dev are providing us id_token from their app
            */
            $url = "https://oauth2.googleapis.com/tokeninfo";
            $response = Http::get($url, [
                'id_token' => $request->code,
            ]);

            if(!$response->ok()) {
                return response()->json([
                    "response_code" => 402,
                    "response_message" => "Invalid Access Token"
                ], 402);
            } else {
                $email = $response['email'];
                // $email = $response->email;
                $exists = DB::table('tbl_users')->where('isActive',1)->where('email', $email)->exists();
                if($exists) {
                    $data = DB::table('tbl_users')->where('email', $email)->get();
                    return response()->json([
                        "response_code" => 200,
                        "response_message" => "Ok",
                        "success" => $data[0]
                    ], 200);
                } else {
                            $length = 50;
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $charactersLength = strlen($characters);
                            $randomString = '';

                            for ($i = 0; $i < $length; $i++) {
                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                            }

                            // $randomString;
                            
                            function random_password( $lengthh = 12 ) {
                                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                                $password = substr( str_shuffle( $chars ), 0, $lengthh );
                                return $password;
                            }
                            $pass = random_password();
                            $id = DB::table('tbl_users')-> insertGetId(array(
                                'name'=> $response['name'],
                                'email'=>$response['email'],
                                'password'=>$pass,
                                'payment_status'=>0,
                                'token'=>$randomString,
                                'provider_id' => $response['sub'],
                                'provider_name' => 'GOOGLE'
                                // 'fr' => $response['picture']
                            ));

                            $userinfo = DB::table('tbl_users')->where('id',$id)->get();


							/*
                            $success['id'] =  $userinfo[0]->id;
                            $success['name'] =  $userinfo[0]->name;
                            $success['email'] =  $userinfo[0]->email;
                            $success['contact'] =  $userinfo[0]->contact;
                            $success['password'] = $userinfo[0]->password;
                            $success['dob'] =  $userinfo[0]->dob;
                            $success['payment_status'] =  $userinfo[0]->payment_status;
                            $success['token'] =  $userinfo[0]->token;
                            $success['height'] =  $userinfo[0]->height;
                            $success['weight'] =  $userinfo[0]->weight;
                            $success['frontshot'] =  $userinfo[0]->frontshot;
                            $success['backshot'] =  $userinfo[0]->backshot;
                            $success['provider_id'] =  $userinfo[0]->provider_id;
                            $success['provider_name'] =  $userinfo[0]->provider_name;
                            $success['cover_pic'] =  $userinfo[0]->cover_pic;
							$success['current_shot'] =  $userinfo[0]->current_shot;
                            */


                            return response()->json([
                                "response_code" => 201,
                                "response_message" => "New user created",
                                "success" => $userinfo[0]
                            ], 201);
                    }
                
            }

    }

    /**
     * only for generating access codes
     */
    public function GloginCallback(Request $request)
    {
        
            $Gdriver = Socialite::driver('google'); 
            try{
                $tokens = $Gdriver->stateless()->getAccessTokenResponse($request->code);
            } catch(\GuzzleHttp\Exception\RequestException $e) {
                throw new \ErrorException("Try again with new access code");
            }
            
            $access_token = $tokens['access_token'];
            
            $url = "https://www.googleapis.com/oauth2/v3/userinfo";
            $response = Http::get($url, [
                'access_token' => $access_token,
            ]);

            if(!$response->ok()) {
                throw new \ErrorException('Access token expired. try again');
            }

            // return view('json', ['data'=> $response]);
            return $response->json();
        
    }
    
    /* for generating access code only */
    public function FloginCallback(Request $request)
    {
		
        /*
        $code = $request->code;
        $Fdriver = Socialite::driver('facebook'); 
        //$response = Http::get('https://graph.facebook.com/v14.0/oauth/access_token?client_id='.env('FACEBOOK_CLIENT_ID').'&redirect_uri=http://localhost/brad/Flogin/callback&client_secret='.env('FACEBOOK_CLIENT_SECRET').'&code='.$code);
        try{
            $tokens = $Fdriver->stateless()->getAccessTokenResponse($code);
        } catch(\GuzzleHttp\Exception\RequestException $e) {
            return response()->json([
                "response_code" => 401,
                "response_message" => "Invalid Access Code"
            ], 401);
        }
       
        $fb_access_token =  $tokens['access_token'];
        return $fb_access_token;
        */
    }
	
	public function Flogin(Request $request)
    {
		/*$myfile = fopen(public_path('logs.txt'), "w");
		fwrite($myfile, $request);
		fclose($myfile);
		exit;
        return $request;*/
		
        if(empty($request->token)) {
            return response()->json([
                "response_code" => 401,
                "response_message" => "Access Token is mandatory"
            ], 401);
        }

        $fb_access_token = $request->token;
        $user = Socialite::driver('facebook')->userFromToken($fb_access_token);
		//dd($user);exit;
		
        /*$myfile = fopen(public_path('logs.txt'), "w");
		fwrite($myfile, $user);
		fclose($myfile);
		exit;
        return $request;*/
        
		if(!$user) {
            return response()->json([
                "response_code" => 402,
                "response_message" => "Invalid Access Token"
            ], 402);
        } else {
                
                $data['id'] = $user->getId();
                $data['name'] = $user->getName();
                $data['email'] = $user->getEmail();
                $data['avatar'] = $user->getAvatar();

				
			
		
				

                $email = $data['email'];
                $exists = DB::table('tbl_users')->where('isActive',1)->where('email', $email)->exists();
                if($exists) {
                    $data = DB::table('tbl_users')->where('email', $email)->get();
                    return response()->json([
                        "response_code" => 200,
                        "response_message" => "Ok",
                        "success" => $data[0]
                    ], 200);
                } else {
                    $length = 50;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';

                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    // $randomString;
                    
                    function random_password( $lengthh = 12 ) {
                        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                        $password = substr( str_shuffle( $chars ), 0, $lengthh );
                        return $password;
                    }
                    
                    
                            $pass = random_password();
                            $id = DB::table('tbl_users')->insertGetId(array(
                                'name'=> $data['name'],
                                'email'=>$data['email'],
                                'password'=>$pass,
                                'payment_status'=>0,
                                'token'=>$randomString,
                                'provider_id' => $data['id'],
                                'provider_name' => 'FACEBOOK',
                                'cover_pic' => $data['avatar']
                            ));

                            $userinfo = DB::table('tbl_users')->where('id',$id)->get();

                            $success['id'] =  $userinfo[0]->id;
                            $success['name'] =  $userinfo[0]->name;
                            $success['email'] =  $userinfo[0]->email;
                            $success['contact'] =  $userinfo[0]->contact;
                            $success['password'] = $userinfo[0]->password;
                            $success['dob'] =  $userinfo[0]->dob;
                            $success['payment_status'] =  $userinfo[0]->payment_status;
                            $success['token'] =  $userinfo[0]->token;
                            $success['height'] =  $userinfo[0]->height;
                            $success['weight'] =  $userinfo[0]->weight;
                            $success['frontshot'] =  $userinfo[0]->frontshot;
                            $success['backshot'] =  $userinfo[0]->backshot;
                            $success['provider_id'] =  $userinfo[0]->provider_id;
                            $success['provider_name'] =  $userinfo[0]->provider_name;
                            $success['cover_pic'] =  $userinfo[0]->cover_pic;
                            $success['isQuestionsSubmitted'] =  $userinfo[0]->isQuestionsSubmitted;
                            
                            


                            return response()->json([
                                "response_code" => 201,
                                "response_message" => "New user created",
                                "success" => $success[0]
                            ], 201);
                }
        }
        
    }

    

    public function Ilogin(Request $request)
    {


        if(empty($request->code)) {
            return response()->json([
                "response_code" => 201,
                "response_message" => "Access Code is mandatory"
            ], 201);
        }


        $provider_id=$request->code;
        // $name=$request->name;
        // $email=$request->email;
        // $contact=$request->contact;
        // $dob=$request->dob;

        $exist=DB::table('tbl_users')->where('isActive',1)->where('provider_id',$provider_id)->where('provider_name','IOS')->get()->count();

        if($exist){


            $data = DB::table('tbl_users')->where('provider_id',$provider_id)->where('provider_name','IOS')->get();
                return response()->json([
                    "response_code" => 200,
                    "response_message" => "Ok",
                    "success" => $data[0]
                ], 200);

        }


        else{


            

        $length = 50;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }




            $id = DB::table('tbl_users')-> insertGetId(array(
                'provider_id' =>$provider_id,
                'provider_name' => 'IOS',
                'token'=>$randomString,
                'payment_status'=>0,
            ));


            
        $userinfo = DB::table('tbl_users')->where('id',$id)->get();

        return response()->json([
            "response_code" => 201,
            "response_message" => "New user created",
            "success" => $userinfo[0],
        ], 201);


   







        }






    }


    public function ios_login_dev(Request $request)
    {

        $providerId = $request->token;
        $providerName = 'APPLE';
        $exists = DB::table('tbl_users')->where('isActive',1)->where('provider_id',$providerId)->where('provider_name',$providerName)->exists();
        if($exists) {
             $data = DB::table('tbl_users')->where('provider_id',$providerId)->where('provider_name',$providerName)->get();
                return response()->json([
                    "response_code" => 200,
                    "response_message" => "User exists",
                    "success" => $data[0]
                ], 200);
        } else {
            
            
            
                return response()->json([
                    "response_code" => 201,
                    "response_message" => "User does not exists",
                ], 201);
        }
    }
    
    
    public function ios_login(Request $request)
    {

        $providerId = $request->token;
        $providerName = 'APPLE';
        $exists = DB::table('tbl_users')->where('isActive',1)->where('provider_id',$providerId)->where('provider_name',$providerName)->exists();
        if($exists) {
             $data = DB::table('tbl_users')->where('provider_id',$providerId)->where('provider_name',$providerName)->get();
                return response()->json([
                    "response_code" => 200,
                    "response_message" => "User exists",
                    "success" => $data[0]
                ], 200);
        } else {
            
            if($request->has('name')) {
                $name = $request->name;
            } else {
                $name = null;
            }
            
            if($request->has('email')) {
                $email = $request->email;
            } else {
                $email = null;
            }
            
            $length = 50;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';

                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    // $randomString;
                    
                    function random_password( $lengthh = 12 ) {
                        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                        $password = substr( str_shuffle( $chars ), 0, $lengthh );
                        return $password;
                    }
                    
                    
                            $pass = random_password();
                            $id = DB::table('tbl_users')->insertGetId(array(
                                'name'          => $name,
                                'email'         => $email,
                                'password'      => Hash::make($pass),
                                'payment_status'=>0,
                                'token'         =>  $randomString,
                                'provider_id'   => $request->token,
                                'provider_name' => $providerName,
                            ));

                            $userinfo = DB::table('tbl_users')->where('id',$id)->get();

                            $success['id'] =  $userinfo[0]->id;
                            $success['name'] =  $userinfo[0]->name;
                            $success['email'] =  $userinfo[0]->email;
                            $success['contact'] =  $userinfo[0]->contact;
                            $success['password'] = $userinfo[0]->password;
                            $success['dob'] =  $userinfo[0]->dob;
                            $success['payment_status'] =  $userinfo[0]->payment_status;
                            $success['token'] =  $userinfo[0]->token;
                            $success['height'] =  $userinfo[0]->height;
                            $success['weight'] =  $userinfo[0]->weight;
                            $success['frontshot'] =  $userinfo[0]->frontshot;
                            $success['backshot'] =  $userinfo[0]->backshot;
                            $success['provider_id'] =  $userinfo[0]->provider_id;
                            $success['provider_name'] =  $userinfo[0]->provider_name;
                            $success['cover_pic'] =  $userinfo[0]->cover_pic;

                            return response()->json([
                                "response_code" => 201,
                                "response_message" => "New user created",
                                "success" => $success
                            ], 201);
            
        }
    }

    


    
}
