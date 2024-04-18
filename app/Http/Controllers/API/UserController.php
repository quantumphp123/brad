<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App; 
use Mail;
use DB;
use Carbon\Carbon;
use Hash;
use App\Services\FCMService;
use Validator,Redirect,Response,File;

use App\Http\Controllers\Controller as Controller;



class UserController extends Controller
 
{	
    	    
    
    
    
    public function submit_question(Request $request)
    {


		$validator = Validator::make($request->all(), [ 

			// 'email'=>'required|exists:tbl_users',
  
		  ]);
  
  
  
		   if ($validator->fails()){
  
			  return response()->json(
  
				  [
  
					  'response_code' => 401,
  
					  'response_message' => $validator->errors()->first()
  
				  ],
  
				  401
  
			  );
  
		  }

		



        $user_id = $request->user_id;
        
        
        // dd( $user_id);
        
        $page1_soln = $request->page1;
        
        // dd( $page1_soln);
        foreach($page1_soln as $page1) {
            $question_id = $page1['question_id'];
            $option = $page1['option'];
            
                foreach($option as $opt) {
                    DB::table('question_solution')->insert([
                        "user_id" => $user_id,
                        "question_id" => $question_id,
                        "option_id" => $opt['option_id']
                    ]);
                }
        }



        $page2_soln = $request->page2;
        if(!empty($page2_soln)) {
            foreach($page2_soln as $page2) {
                $question_id = $page2['question_id'];
                $option = $page2['option'];
                
                    foreach($option as $opt) {
                        DB::table('question_solution')->insert([
                            "user_id" => $user_id,
                            "question_id" => $question_id,
                            "option_id" => $opt['option_id'],
                        ]);
                    }
            }
        }


        $page3_soln = $request->page3;
        foreach($page3_soln as $page3) {
            $question_id = $page3['question_id'];
            $option = $page3['option'];
            
                foreach($option as $opt) {
                    DB::table('question_solution')->insert([
                        "user_id" => $user_id,
                        "question_id" => $question_id,
                        "option_id" => $opt['option_id']
                    ]);
                }
        }

        $page4_soln = $request->page4;
        foreach($page4_soln as $page4) {
            $question_id = $page4['question_id'];

                DB::table('question_solution')->insert([
                    "user_id" => $user_id,
                    "question_id" => $question_id,
                    "text" => $page4['answer']
                ]);
        }        


        $userName = DB::table('tbl_users')->where('id', $user_id)->pluck('name');
        
        // Update the isQuestionsSubmitted field to 1 for the user
             DB::table('tbl_users')
            ->where('id', $user_id)
            ->update(['isQuestionsSubmitted' => 1]);

        DB::table('admin_notifications')->insert([
			"user_id" 		=> $user_id,
			"title"   		=> "Assign Meal Request",
			"description" 	=> "Assign Meal Request to ".$userName[0],
			"time"          => NOW(),
// 			"seen"			=> 0
		]);
		
// 		return "false";

        return response()->json([
            "response_code" => 200,
            "response_message" => "Answer submitted and Notification sent to admin"
         ], 200);

    }



	public function submit_question_ios(Request $request)
	{

		$userId=$request->user_id;



		$page1_soln = $request->page1;
		
        foreach($page1_soln as $questionId => $answers) {
			 $question_id=$questionId;
			foreach($answers as $answer) {


				foreach($answer as $opt) {
                    DB::table('question_solution')->insert([
                        "user_id" => $userId,
                        "question_id" => $question_id,
                        "option_id" => $opt['option_id']
                    ]);
                }
			
			}
            
        
        }

		$page2_soln=$request->page2;

		foreach($page2_soln as $questionId=>$answers)
		{
			 $question_id=$questionId;

			foreach($answers as $answer)
			{

				foreach($answer as $opt) {
                    DB::table('question_solution')->insert([
                        "user_id" => $userId,
                        "question_id" => $question_id,
                        "option_id" => $opt['option_id']
                    ]);
                }


			}


		}


		$page3_soln=$request->page3;

		foreach($page3_soln as $questionId=>$answers)
		{
			$question_id=$questionId;

			foreach($answers as $answer)
			{
				
				foreach($answer as $opt)
				{
					DB::table('question_solution')->insert([
                        "user_id" => $userId,
                        "question_id" => $question_id,
                        "option_id" => $opt['option_id']
                    ]);

				}

			}

		}


		$page4_soln=$request->page4;

		foreach($page4_soln as $page4) {
            $question_id = $page4['question_id'];

                DB::table('question_solution')->insert([
                    "user_id" => $userId,
                    "question_id" => $question_id,
                    "text" => $page4['answer']
                ]);
        }        


		return response()->json([
            "response_code" => 200,
            "response_message" => "Answer submitted"
         ], 200);



	}




    
  public function questions()
    {


         /**page 1 */
        $questions = DB::table('questions')->get(['id', 'question', 'page_no']);

        /**
         * returns ques on each page
         */

        $pages = DB::table('questions')->distinct()->pluck('page_no');
        if(count($pages) < 0) {
            return response()->json([
				"response_code" => 404,
                "response_message" => "No Question found",
            ], 404);
        }

        /**
         * page 1
         */
        $page1_ques_array = array();
        $page1_ques = DB::table('questions')->where('page_no', $pages[0])->get(['id', 'question']);

        foreach($page1_ques as $pg1) {
            $page = DB::table('options')->where('question_id', $pg1->id)->get(['id as option_id', 'options']);
            $obj = new \stdClass;
            $obj->question_id = $pg1->id;
            $obj->question = $pg1->question;
            $obj->option = $page;
            array_push($page1_ques_array, $obj);
        }
        


        /**
         * page 2
         */
        $page2_ques_array = array();
        $page2_ques = DB::table('questions')->where('page_no', $pages[1])->get(['id', 'question','answe_type']);
        
        foreach($page2_ques as $pg1) {
            $page = DB::table('options')->where('question_id', $pg1->id)->get(['id as option_id', 'options']);
            $obj = new \stdClass;
            $obj->question_id = $pg1->id;
            $obj->question = $pg1->question;
            $obj->asnwer_type = $pg1->answe_type;
            $obj->option = $page;
            array_push($page2_ques_array, $obj);
        }

        /**
         * page 3
         */
        $page3_ques_array = array();
        $page3_ques = DB::table('questions')->where('page_no', $pages[2])->get(['id', 'question']);
        
        foreach($page3_ques as $pg1) {
            $page = DB::table('options')->where('question_id', $pg1->id)->get(['id as option_id', 'options']);
            $obj = new \stdClass;
            $obj->question_id = $pg1->id;
            $obj->question = $pg1->question;
            $obj->option = $page;
            array_push($page3_ques_array, $obj);
        }



        /**
         * page 4
         */
        $page4_ques_array = array();
        $page4_ques = DB::table('questions')->where('page_no', $pages[3])->get(['id', 'question']);
        
        foreach($page4_ques as $pg1) {
            $page = DB::table('options')->where('question_id', $pg1->id)->get(['id as option_id']);
            $obj = new \stdClass;
            $obj->question_id = $pg1->id;
            $obj->question = $pg1->question;
            array_push($page4_ques_array, $obj);
        }


        return response()->json([
            "page1" => $page1_ques_array,
            "page2" => $page2_ques_array,
            "page3" => $page3_ques_array,
            "page4" => $page4_ques_array,
            // "page5" => $page5,
            "response_code" => 200,
			"response_message" => "Ok"
        ], 200);

    }



	/** 

     * login api 

     * 

     * @return \Illuminate\Http\Response 

     */ 

//     public function login(Request $request){

        

//         $validator = Validator::make($request->all(), [ 

//           //'email'=>'required|exists:tbl_users',

//         ]);



//          if ($validator->fails()){

//             return response()->json(

//                 [

//                     'response_code' => 401,

//                     'response_message' => $validator->errors()->first()

//                 ],

//                 401

//             );

//         }
// 		else{

			

// 			$email = $request->email;

// 			$password = $request->password;

			 

// 			$result = DB::table('tbl_users')->where('isActive',1)->where('email',$email)->orWhere('contact', $email)->exists();

// 			if($result){

// 				$password_check=DB::table('tbl_users')->where('isActive',1)->where('email',$email)->orWhere('contact', $email)->get();

// 				if(Hash::check($password,$password_check[0]->password)){


// 					$userinfo = DB::table('tbl_users')->where('email',$email)->orWhere('contact',$email)->get();



// 					$success['id'] =  $userinfo[0]->id;

// 					$success['name'] =  $userinfo[0]->name;

// 					$success['email'] =  $userinfo[0]->email;

// 					$success['contact'] =  $userinfo[0]->contact;

// 					$success['password'] =  $userinfo[0]->password;

// 					$success['dob'] =  $userinfo[0]->dob;

// 					$success['gender'] =  $userinfo[0]->gender;

// 					$success['height'] =  $userinfo[0]->height;

// 					$success['weight'] =  $userinfo[0]->weight;

// 					$success['body_type'] =  $userinfo[0]->body_type;

// 					$success['payment_status'] =  $userinfo[0]->payment_status;

// 					$success['frontshot'] =  $userinfo[0]->frontshot;

// 					$success['backshot'] =  $userinfo[0]->backshot;

// 					$success['cover_pic'] =  $userinfo[0]->cover_pic;

// 					$success['current_shot'] =  $userinfo[0]->current_shot;
					
// 					$success['isQuestionsSubmitted'] =  $userinfo[0]->isQuestionsSubmitted;

					

// 			return response()->json(['success'=>$success,'response_code' => 200],200); 

// 			exit();

			

// 			}
			
// 			else{

// 			return response()->json([
// 				'response_code' => 401,
// 				'response_message'=>'Incorrect Password!'
// 			],401); 


		
// 			}


// 				}


// 				else{

// 					return response()->json([
// 						'response_code' => 401,
// 						'response_message'=>'Email or Phone number not exist!'
// 					],401); 


// 				}


			

// 		}

		

//         }

public function login(Request $request){

    $validator = Validator::make($request->all(), [ 
        //'email'=>'required|exists:tbl_users',
    ]);

    if ($validator->fails()){
        return response()->json([
            'response_code' => 401,
            'response_message' => $validator->errors()->first()
        ], 401);
    } else {
        $email = $request->email;
        $password = $request->password;
        $fcmToken = $request->fcm_token; // New parameter for FCM token

        $result = DB::table('tbl_users')
                    ->where('isActive', 1)
                    ->where(function($query) use ($email) {
                        $query->where('email', $email)
                              ->orWhere('contact', $email);
                    })
                    ->exists();

        if($result){
            $password_check = DB::table('tbl_users')
                                ->where('isActive', 1)
                                ->where(function($query) use ($email) {
                                    $query->where('email', $email)
                                          ->orWhere('contact', $email);
                                })
                                ->get();

            if(Hash::check($password, $password_check[0]->password)){
                // Update FCM token
                DB::table('tbl_users')
                    ->where('email', $email)
                    ->orWhere('contact', $email)
                    ->update(['fcm_token' => $fcmToken]);

                $userinfo = DB::table('tbl_users')
                                ->where('email', $email)
                                ->orWhere('contact', $email)
                                ->get();

                $success = [
                    'id' => $userinfo[0]->id,
                    'name' => $userinfo[0]->name,
                    'email' => $userinfo[0]->email,
                    'contact' => $userinfo[0]->contact,
                    'dob' => $userinfo[0]->dob,
                    'gender' => $userinfo[0]->gender,
                    'height' => $userinfo[0]->height,
                    'weight' => $userinfo[0]->weight,
                    'body_type' => $userinfo[0]->body_type,
                    'payment_status' => $userinfo[0]->payment_status,
                    'frontshot' => $userinfo[0]->frontshot,
                    'backshot' => $userinfo[0]->backshot,
                    'cover_pic' => $userinfo[0]->cover_pic,
                    'current_shot' => $userinfo[0]->current_shot,
                    'isQuestionsSubmitted' => $userinfo[0]->isQuestionsSubmitted,
                    'fcm_token' => $fcmToken
                ];

                return response()->json(['success' => $success, 'response_code' => 200], 200); 
            } else {
                return response()->json([
                    'response_code' => 401,
                    'response_message' => 'Incorrect Password!'
                ], 401); 
            }
        } else {
            return response()->json([
                'response_code' => 401,
                'response_message' => 'Email or Phone number not exist!'
            ], 401); 
        }
    }
}


		

		

		

	public function signup(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

            'email'=>'required|unique:tbl_users,email',

            'contact'=>'required|unique:tbl_users,contact',

			//'dob' => 'required |date_format:Y/m/d'

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first(),
					

                ],

                401

            );

        }
		
		else
		{

			

			$length = 50;

			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			$charactersLength = strlen($characters);

			$randomString = '';

			for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

			}

			$randomString;

			

			$id = DB::table('tbl_users')-> insertGetId(array(

			'name'=>$request->name,

			'email'=>$request->email,

			'contact'=>$request->contact,

			'password'=>Hash::make($request->password),

			'dob'=>$request->dob,

			'payment_status'=>0,

			'token'=>$randomString

			));

			

			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			$success['id'] =  $userinfo[0]->id;

			$success['name'] =  $userinfo[0]->name;

			$success['email'] =  $userinfo[0]->email;

			$success['contact'] =  $userinfo[0]->contact;

			$success['password'] =  $userinfo[0]->password;

			$success['dob'] =  $userinfo[0]->dob;

			$success['payment_status'] =  $userinfo[0]->payment_status;

			$success['token'] =  $userinfo[0]->token;

			$success['height'] =  $userinfo[0]->height;

			$success['weight'] =  $userinfo[0]->weight;

			$success['frontshot'] =  $userinfo[0]->frontshot;

			$success['backshot'] =  $userinfo[0]->backshot;

			

			

			if($userinfo){

			return response()->json(['success'=>$success,'response_code' => 200],200); 

			exit();

			}

			

		}

		

		}

		

		

		public function update_user_info(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           'id'=>'required|exists:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

					
                ],

                401

            );

        }else{

			

			$id = $request->id;

			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			$front_shot =  $userinfo[0]->frontshot;

			$back_shot =  $userinfo[0]->backshot;

			$coverpic =  $userinfo[0]->cover_pic;

			

			if($request->file('frontshot')){

			$imageName = time().'.'.$request->frontshot->extension();

			$request->frontshot->move(public_path('uploads/frontshot'),$imageName);

			$frontshot=url('public/uploads/frontshot').'/'.$imageName;

			}else{

			$frontshot=$front_shot; 

			}



			if($request->file('backshot')){

			$imageName2 = time().'.'.$request->backshot->extension();

			$request->backshot->move(public_path('uploads/backshot'),$imageName2);

			$backshot=url('public/uploads/backshot').'/'.$imageName2;

			}else{

			$backshot=$back_shot; 

			}

			

			if($request->file('cover_pic')){

			$imageName3 = time().'.'.$request->cover_pic->extension();

			$request->cover_pic->move(public_path('uploads/cover_pic'),$imageName3);

			$cover_pic=url('public/uploads/cover_pic').'/'.$imageName3;

			}else{

			$cover_pic=$coverpic; 

			}			

			

			

			DB::table('tbl_users')->where('id',$id)->update(

			array(

			'frontshot'=>$frontshot,

			'backshot'=>$backshot,

			'cover_pic'=>$cover_pic,

			'height'=>$request->height,

			'weight'=>$request->weight,

			'gender'=>$request->gender,

			'body_type'=>$request->body_type

			));

			



			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			$success['id'] =  $userinfo[0]->id;

			$success['name'] =  $userinfo[0]->name;

			$success['email'] =  $userinfo[0]->email;

			$success['contact'] =  $userinfo[0]->contact;

			$success['password'] =  $userinfo[0]->password;

			$success['dob'] =  $userinfo[0]->dob;

			$success['payment_status'] =  $userinfo[0]->payment_status;

			$success['token'] =  $userinfo[0]->token;

			$success['height'] =  $userinfo[0]->height;

			$success['weight'] =  $userinfo[0]->weight;

			$success['gender'] =  $userinfo[0]->gender;

			$success['body_type'] =  $userinfo[0]->body_type;

			$success['frontshot'] =  $userinfo[0]->frontshot;

			$success['backshot'] =  $userinfo[0]->backshot;

			$success['cover_pic'] =  $userinfo[0]->cover_pic;

			

			

			if($userinfo){

			return response()->json(['success'=>$success,'response_code' => 200],200); 

			exit();

			}

			

		}

		

		}

		

		

		public function update_user_profile(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           'id'=>'required|exists:tbl_users',
		   'dob'=>'date_format:Y-m-d',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()


                ],

                401

            );

        }else{

			

			$id = $request->id;

			if($request->name){

				DB::table('tbl_users')->where('id',$id)->update(

					array(
		
					'name'=>$request->name,
		
					));
			}

			if($request->email){

				$check=DB::table('tbl_users')->where('email',$request->email)->count();
				if($check){

					return response()->json([
						'response_message'=>'Email Already exist!',
						'response_code' => 401
					],401); 

				}
		

				else{

				DB::table('tbl_users')->where('id',$id)->update(

					array(
		
					'email'=>$request->email,
		
					));
				}
					

			}

			if($request->contact){

				$check=DB::table('tbl_users')->where('contact',$request->contact)->count();
				if($check){

					return response()->json([
						'response_message'=>'Contact Already exist!',
						'response_code' => 401
					],401); 

				}

				else{

				

				DB::table('tbl_users')->where('id',$id)->update(

					array(
		
					'contact'=>$request->contact,
		
					));
				}

			}


			if($request->dob){

				DB::table('tbl_users')->where('id',$id)->update(

					array(
		
					'dob'=>$request->dob,
		
					));

			}
			

			


			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			$success['id'] =  $userinfo[0]->id;

			$success['name'] =  $userinfo[0]->name;

			$success['email'] =  $userinfo[0]->email;

			$success['contact'] =  $userinfo[0]->contact;

			$success['password'] =  $userinfo[0]->password;

			$success['dob'] =  $userinfo[0]->dob;

			$success['gender'] =  $userinfo[0]->gender;

			$success['height'] =  $userinfo[0]->height;

			$success['weight'] =  $userinfo[0]->weight;

			$success['body_type'] =  $userinfo[0]->body_type;

			$success['payment_status'] =  $userinfo[0]->payment_status;

			$success['frontshot'] =  $userinfo[0]->frontshot;

			$success['backshot'] =  $userinfo[0]->backshot;

			$success['cover_pic'] =  $userinfo[0]->cover_pic;

			$success['current_shot'] =  $userinfo[0]->current_shot;

			

			

			

			if($userinfo){

			return response()->json(['success'=>$success,'response_code' => 200],200); 

			exit();

			}

			

		}

		

		}

		

		

		public function weekly_checkin(Request $request){

      

			// return $request->input();
	  
	  
	  
			  $validator = Validator::make($request->all(), [ 
	  
				 // 'email'=>'required|unique:tbl_users',
	  
				 // 'contact'=>'required|unique:tbl_users',
	  
			  ]);
	  
	  
	  
			   if ($validator->fails()){
	  
				  return response()->json(
	  
					  [
	  
						  'response_code' => 401,
	  
						  'response_message' => $validator->errors()->first()
	  
					  ],
	  
					  200
	  
				  );
	  
			  }else{
	  
				  
	  
				  $user_id = $request->user_id;
	  
				  
	  
				  $userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();
	  
				   if(!$userinfo_exist){
	  
				   return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 
	  
				  exit();
	  
				   }
	  
				   $todayData=DB::table('weekly_checks')->where('user_id',$user_id)->whereDate('created_at',Carbon::today())->count();
	  
				   $start_date=Carbon::now();
				   $end_date=Carbon::now()->addDays(-7);
				  
				   $weekData= DB::table('weekly_checks')->where('user_id',$user_id)->whereBetween('created_at',[$end_date,$start_date])->count();
	  
	  
				  if( !$todayData && !$weekData ){
	  
	  
	  
					  if($request->file('frontshot')){
	  
						  $imageName = time().'.'.$request->frontshot->extension();
			  
						  $request->frontshot->move(public_path('uploads/frontshot'),$imageName);
			  
						  $frontshot=url('public/uploads/frontshot').'/'.$imageName;
			  
						  }else{
			  
						  $frontshot=null; 
			  
						  }
			  
			  
			  
						  if($request->file('backshot')){
			  
						  $imageName2 = time().'.'.$request->backshot->extension();
			  
						  $request->backshot->move(public_path('uploads/backshot'),$imageName2);
			  
						  $backshot=url('public/uploads/backshot').'/'.$imageName2;
			  
						  }else{
			  
						  $backshot=null; 
			  
						  }
			  
						   
			  
						  
			  
						  $id = DB::table('weekly_checks')-> insertGetId(array(
			  
						  'user_id'=>$request->user_id,
			  
						  'front_shot'=>$frontshot,
			  
						  'back_shot'=>$backshot,
			  
						  'weight'=>$request->weight,
			  
						  'comments'=>$request->comments,
			  
						  'question'=>$request->question
			  
						  ));
			  
						  
			  
						  
			  
						  
			  
						  DB::table('tbl_users')->where('id',$user_id)->update(
			  
						  array(
			  
						  'current_shot'=>$frontshot
			  
						  ));


						  $userinfo = DB::table('weekly_checks')->where('id',$id)->get();
	  
						  $success['user_id'] =  $userinfo[0]->user_id;
			  
						  $success['front_shot'] =  $userinfo[0]->front_shot;
			  
						  $success['back_shot'] =  $userinfo[0]->back_shot;
			  
						  $success['weight'] =  $userinfo[0]->weight;
			  
						  $success['comments'] =  $userinfo[0]->comments;
			  
						  $success['question'] =  $userinfo[0]->question;
			  
						  
			  
						  if($userinfo){
			  
						  return response()->json(['success'=>$userinfo,'response_code' => 200],200); 
			  
						  exit();
			  
						  }else{
			  
							  return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 
			  
						  exit();
			  
						  }
			  
	  
	  
				  }
	  
				  else{

					return response()->json([

						'response_code'=>401,
						'response_message'=>"It's not been a week since you checked last time!"
					],401);
				  }
				   
	  
				  
	  
			  }
	  
			  
	  
			  }
	  
		

		

		public function update_weekly_checkin(Request $request){

      

        $validator = Validator::make($request->all(), [ 

           'id'=>'required|exists:weekly_checks',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],
												
					
		

                401

            );

        }else{

			

			$id = $request->id;

			

		    $userinfo = DB::table('weekly_checks')->where('id',$id)->get();

			$front_shot =  $userinfo[0]->front_shot;

			$back_shot =  $userinfo[0]->back_shot;

			

			if($request->file('frontshot')){

			$imageName = time().'.'.$request->frontshot->extension();

			$request->frontshot->move(public_path('uploads/frontshot'),$imageName);

			$frontshot=url('public/uploads/frontshot').'/'.$imageName;

			}else{

			$frontshot=$front_shot; 

			}



			if($request->file('backshot')){

			$imageName2 = time().'.'.$request->backshot->extension();

			$request->backshot->move(public_path('uploads/backshot'),$imageName2);

			$backshot=url('public/uploads/backshot').'/'.$imageName2;

			}else{

			$backshot=$back_shot; 

			}

			

			DB::table('weekly_checks')->where('id',$id)->update(

			array(

			'front_shot'=>$frontshot,

			'back_shot'=>$backshot,

			'weight'=>$request->weight,

			'comments'=>$request->comments,

			'question'=>$request->question

			));

			

			

			

			$userinfo = DB::table('weekly_checks')->where('id',$id)->get();

			$success['user_id'] =  $userinfo[0]->user_id;

			$success['front_shot'] =  $userinfo[0]->front_shot;

			$success['back_shot'] =  $userinfo[0]->back_shot;

			$success['weight'] =  $userinfo[0]->weight;

			$success['comments'] =  $userinfo[0]->comments;

			$success['question'] =  $userinfo[0]->question;

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}
	

			

		}

		

		}

		

		public function weekly_checkin_history(Request $request){

      

        $validator = Validator::make($request->all(), [ 

           //'id'=>'required|exists:weekly_checks',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401
            );

        }else{

			

			$user_id = $request->user_id;

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();
	

			 }

			

			$userinfo = DB::table('weekly_checks')->where('user_id',$user_id)->get();



			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}

			

		}
	}






	public function monthly_checkin(Request $request){

      


		$validator = Validator::make($request->all(), [ 

			'weight'=>'required|numeric',
			'waist'=>'required|numeric',
			   'left_arm'=>'required|numeric',
			'right_arm'=>'required|numeric',
			'left_quad'=>'required|numeric',
			'right_quad'=>'required|numeric'

	

		]);



		 if ($validator->fails()){

			return response()->json(

				[

					'response_code' => 401,

					'response_message' => $validator->errors()->first()

				],

				
		
				401

			);

			}
			else{

			

			$user_id = $request->user_id;
 
			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();
	


			 }


			 $todayData=DB::table('monthly_checks')->where('user_id',$user_id)->whereDate('created_at',Carbon::today())->count();

			 $start_date=Carbon::now();
			 $end_date=Carbon::now()->addMonth(-1);
			
			 $monthData= DB::table('monthly_checks')->where('user_id',$user_id)->whereBetween('created_at',[$end_date,$start_date])->count();



			if( !$todayData && !$monthData ){


				if($request->file('frontshot')){

					$imageName = time().'.'.$request->frontshot->extension();
		
					$request->frontshot->move(public_path('uploads/frontshot'),$imageName);
		
					$frontshot=url('public/uploads/frontshot').'/'.$imageName;
		
					}else{
		
					$frontshot=null; 
		
					}
		
		
		
					if($request->file('backshot')){
		
					$imageName2 = time().'.'.$request->backshot->extension();
		
					$request->backshot->move(public_path('uploads/backshot'),$imageName2);
		
					$backshot=url('public/uploads/backshot').'/'.$imageName2;
		
					}
					else{
		
					$backshot=null; 
		
					}
		
					 
		
					
		
					$id=DB::table('monthly_checks')-> insertGetId(array(
		
					'user_id'=>$request->user_id,
		
					'front_shot'=>$frontshot,
		
					'back_shot'=>$backshot,
		
					'weight'=>$request->weight,
		
					'waist'=>$request->waist,
		
					'left_arm'=>$request->left_arm,
		
					'right_arm'=>$request->right_arm,
		
					'left_quad'=>$request->left_quad,
		
					'right_quad'=>$request->right_quad,
		
					'comments'=>$request->comments,
		
					'question'=>$request->question
		
					
					));
		
		
			
		
					DB::table('tbl_users')->where('id',$user_id)->update(
		
					array(
		
					'current_shot'=>$frontshot
		
					));
		

			}

			else{
			
				return response()->json([
					'response_code'=>401,
					'response_message'=>"It's not been a month since you checked last time!"
				],401);


		  }
			

			$userinfo = DB::table('monthly_checks')->where('id',$id)->orderBy('id','desc')->first();

			

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();
		
			}

		

		}

	}
		

		

		public function monthly_checkin_history(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           // 'email'=>'required|unique:tbl_users',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],


                401

            );

        }else{

			

			$user_id = $request->user_id;

			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();

			 }

			 

			

			$userinfo = DB::table('monthly_checks')->where('user_id',$user_id)->orderBy('id','desc')->get();

			

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}

			

		}

		

		}

		

		public function update_monthly_checkin(Request $request){

      

        $validator = Validator::make($request->all(), [ 

           'id'=>'required|exists:monthly_checks',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$id = $request->id;

			

			

			

			 

			 $userinfo = DB::table('monthly_checks')->where('id',$id)->get();

			$front_shot =  $userinfo[0]->front_shot;

			$back_shot =   $userinfo[0]->back_shot;

			

			if($request->file('frontshot')){

			$imageName = time().'.'.$request->frontshot->extension();

			$request->frontshot->move(public_path('uploads/frontshot'),$imageName);

			$frontshot=url('public/uploads/frontshot').'/'.$imageName;

			}else{

			$frontshot=$front_shot; 

			}



			if($request->file('backshot')){

			$imageName2 = time().'.'.$request->backshot->extension();

			$request->backshot->move(public_path('uploads/backshot'),$imageName2);

			$backshot=url('public/uploads/backshot').'/'.$imageName2;

			}else{

			$backshot=$back_shot; 

			}

			

			DB::table('monthly_checks')->where('id',$id)->update(

			array(

			'front_shot'=>$frontshot,

			'back_shot'=>$backshot,

			'weight'=>$request->weight,

			'waist'=>$request->waist,

			'left_arm'=>$request->left_arm,

			'right_arm'=>$request->right_arm,

			'left_quad'=>$request->left_quad,

			'right_quad'=>$request->right_quad,

			'comments'=>$request->comments,

			'question'=>$request->question

			));

			

			

			$userinfo = DB::table('monthly_checks')->where('id',$id)->get();

			$success['user_id'] =  $userinfo[0]->user_id;

			$success['front_shot'] =  $userinfo[0]->front_shot;

			$success['back_shot'] =  $userinfo[0]->back_shot;

			$success['weight'] =  $userinfo[0]->weight;

			$success['waist'] =  $userinfo[0]->waist;

			$success['left_arm'] =  $userinfo[0]->left_arm;

			$success['right_arm'] =  $userinfo[0]->right_arm;

			$success['left_quad'] =  $userinfo[0]->left_quad;

			$success['right_quad'] =  $userinfo[0]->right_quad;

			$success['comments'] =  $userinfo[0]->comments;

			$success['question'] =  $userinfo[0]->question;

			
// 			DB::table('tbl_users')->where('id',$user_id)->update(
		
// 					array(
		
// 					'current_shot'=>$frontshot
		
// 					));

			if($userinfo){

			return response()->json(['success'=>$success,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}

			

		}

		

		}

		

		public function update_cover_pic(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           'id'=>'required|exists:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$id = $request->id;

			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			

			$coverpic =  $userinfo[0]->cover_pic;

			

			

			

			if($request->file('cover_pic')){

			$imageName3 = time().'.'.$request->cover_pic->extension();

			$request->cover_pic->move(public_path('uploads/cover_pic'),$imageName3);

			$cover_pic=url('public/uploads/cover_pic').'/'.$imageName3;

			}else{

			$cover_pic=$coverpic; 

			}			

			

			

			DB::table('tbl_users')->where('id',$id)->update(

			array(

			'cover_pic'=>$cover_pic

			));

			



			

			$userinfo = DB::table('tbl_users')->where('id',$id)->get();

			

			$success['cover_pic'] =  $userinfo[0]->cover_pic;

			

			

			if($userinfo){

			return response()->json(['success'=>$success,'response_code' => 200],200); 

			exit();

			}

			

		}

		

		}

		

		

		public function body_stats(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           // 'email'=>'required|unique:tbl_users',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$user_id = $request->user_id;

			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			if(!$userinfo_exist){

			return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();

			}

			

			$userinfo = DB::table('monthly_checks')->where('user_id',$user_id)->orderBy('id','desc')->get();

			

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}

			

		}

		

		}

		

		public function videos(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           // 'email'=>'required|unique:tbl_users',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$userinfo = DB::table('videos')->orderBy('id','desc')->get();

			

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}else{

				return response()->json(['response_message'=>'Network Issue','response_code' => 401],401); 

			exit();

			}

			

		}

		

		}

		

		

		

		

			

		public function chat(Request $request){

      

			// return $request->input();
	  
	  
	  
	  
			  $validator = Validator::make($request->all(), [ 
	  
				  // 'description'=>'required',
	  
				 // 'contact'=>'required|unique:tbl_users',
	  
			  ]);
	  
	  
	  
			   if ($validator->fails()){
	  
				  return response()->json(
	  
					  [
	  
						  'response_code' => 401,
	  
						  'response_message' => $validator->errors()->first()
	  
					  ],
	  
					  401
	  
				  );
	  
			  }else{
	  
				  
	  
				  $user_id = $request->user_id;
	  
				  
	  
				  $userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();
	  
				   if(!$userinfo_exist){
	  
				   return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 
	  
				  exit();
	  
				   }
	  
				  if($request->file('image')){
	  
					  $imageName = time().'.'.$request->image->extension();
	  
					  $request->image->move(public_path('uploads/chat_image'),$imageName);
		  
					  $image_description=url('public/uploads/chat_image').'/'.$imageName;
	  
	  
	  
	  
					  $id = DB::table('chats')-> insertGetId(array(
	  
						  'from_user'=>$request->user_id,
			  
						  'to_user'=>'admin',
			  
						  'description'=>$image_description,

						  'type'=>'image',

						  'color'=>'#5bc0de'
			  
						  ));
	  
				  }
	  
	  
	  
				  else{
	  
	  
					  $id = DB::table('chats')-> insertGetId(array(
	  
						  'from_user'=>$request->user_id,
			  
						  'to_user'=>'admin',
			  
						  'description'=>$request->description,

						  'type'=>'text',

						  'color'=>'#5bc0de'

			  
						  ));
	  
				  }
	  
		  
	  
				  if($id){
                        // Send FCM notification
                        // $user =  DB::table('tbl_users')->where('id', $user_id)->first(); // Assuming you are using authentication
                        // FCMService::send(
                        //     $user->fcm_token,
                        //     [
                        //         'title' => 'New Message Received',
                        //         'body' => 'You have received a new message'
                        //     ]
                        // );
                
                        return response()->json(['response_message'=>'Message Sent Successfully','response_code' => 200],200); 
                    } else {
                        // If insertion fails
                        return response()->json(['response_message'=>'Failed to send message','response_code' => 500],500);
                    }
                	  
				  exit();
	  
				  }
	  
				  
	  
			  }
	  
			  
	  
			  
	  
			  

		

		

		public function chat_list(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

            'user_id'=>'required',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$user_id = $request->user_id;

			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();

			 }

			

			$userinfo = DB::table('chats')->where('from_user',$user_id)->orWhere('to_user',$user_id)->get();

			//$userinfo = DB::table('chats')->where('to_user',$user_id)->get();

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			

			

			if($userinfo){

			

			exit();

			}

			

		}

		

		}

		public function plans(){

            // return $request->input();



                  $plans = DB::table('plans')->orderBy('id','desc')->get();


                  if($plans){
                      return response()->json(['success'=>$plans,'response_code' => 200],200);
                      exit();
                  }else{
                      return response()->json(['response_message'=>'Network Issue','response_code' => 401],401);
                  exit();
                  }



              }		
			  
			  public function workout(Request $request){

      

      // return $request->input();



        $validator = Validator::make($request->all(), [ 

           // 'description'=>'required',

           // 'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$user_id = $request->user_id;

			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();

			 }


			$workout = DB::table('workout')->where('user_id',$user_id)->get();
			if($workout){
			return response()->json(['success'=>$workout,'response_code' => 200],200);
			exit();
			}else{
			return response()->json(['response_message'=>'Network Issue','response_code' => 401],401);
			exit();
			}

			

		}

		

		}
		
		
		public function meal_plan_question_one(){

            // return $request->input();



                  $plans = DB::table('meal_plan_question_one')->orderBy('id','desc')->get();


                  if($plans){
                  return response()->json(['success'=>$plans,'response_code' => 200],200);
                  exit();
                  }else{
                      return response()->json(['response_message'=>'Network Issue','response_code' => 401],401);
                  exit();
                  }



              }		
		
		
		public function meal_plan_answer_one(Request $request){

      
        $validator = Validator::make($request->all(), [ 

            //'email'=>'required|unique:tbl_users',

            //'contact'=>'required|unique:tbl_users',

        ]);



         if ($validator->fails()){

            return response()->json(

                [

                    'response_code' => 401,

                    'response_message' => $validator->errors()->first()

                ],

                401

            );

        }else{

			

			$user_id = $request->user_id;

			

			$userinfo_exist = DB::table('tbl_users')->where('id',$user_id)->exists();

			 if(!$userinfo_exist){

			 return response()->json(['response_message'=>'User Id Does Not Exists','response_code' => 401],401); 

			exit();

			 }
			 
			$question_one = DB::table('meal_plan_question_one')->where('id',$request->question_one)->exists();
			$question_two = DB::table('meal_plan_question_one')->where('id',$request->question_two)->exists();
			$question_three = DB::table('meal_plan_question_one')->where('id',$request->question_three)->exists();
			$question_four = DB::table('meal_plan_question_one')->where('id',$request->question_four)->exists();
      
			if(!$question_one){
			return response()->json(['response_message'=>'Question Id Does Not Exists','response_code' => 401],401); 
			exit();
			}
			
			if(!$question_two){
			return response()->json(['response_message'=>'Question Id Does Not Exists','response_code' => 401],401); 
			exit();
			}
			
			if(!$question_three){
			return response()->json(['response_message'=>'Question Id Does Not Exists','response_code' => 401],401); 
			exit();
			}
			
			if(!$question_four){
			return response()->json(['response_message'=>'Question Id Does Not Exists','response_code' => 401],401); 
			exit();
			}
			

			$id = DB::table('meal_plan_answer_one')-> insertGetId(array(

			'user_id'=>$request->user_id,
			'question_one'=>$request->question_one,
			'answer_one'=>$request->answer_one,
			'question_two'=>$request->question_two,
			'answer_two'=>$request->answer_two,
			'question_three'=>$request->question_three,
			'answer_three'=>$request->answer_three,
			'question_four'=>$request->question_four,
			'answer_four'=>$request->answer_four

			));

			$userinfo = DB::table('meal_plan_answer_one')->where('user_id',$user_id)->get();

			

			if($userinfo){

			return response()->json(['success'=>$userinfo,'response_code' => 200],200); 

			exit();

			}

			

		}

		

		}
		
	public function forgot_password(Request $request) {
    $email = $request->email;

    // Validate email address format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json([
            "response_code" => 400,
            "response_message" => "Invalid email address format",
        ], 400);
    }

    // Check if email exists in the database
    $exist = DB::table('tbl_users')->where('email', $email)->exists();
    if(!$exist) {
        return response()->json([
            "response_code" => 404,
            "response_message" => "Mail not found",
        ], 404);
    }

    // Generate OTP
    $otp = rand(1000, 9000);

    // Update OTP in the database
    $updateResult = DB::table('tbl_users')->where('email', $email)->update(["otp" => $otp]);
    if(!$updateResult) {
        return response()->json([
            "response_code" => 500,
            "response_message" => "Failed to update OTP",
        ], 500);
    }

    // Prepare email data
    $data = ["email" => $email, "otp" => $otp];
    $user['to'] = $email;

    // Send email
    $success = Mail::send('admin.mail', $data, function ($message) use ($user) { 
        $message->to($user['to']);            
        $message->subject('Forgot password');        
    });

    if (!$success) {
        return response()->json([
            "response_code" => 200,
            "response_message" => "Mail Sent!",
        ], 200);
    } else {
        return response()->json([
            "response_code" => 401,
            "response_message" => "Oops! Mail problem",
        ], 401);
    }
}

                    
                    public function verify_otp(Request $request) 	{
                        $otp = $request->otp;
                        $email = $request->email;
                        $check = DB::table('tbl_users')->where('email', $email)->pluck('otp');
                        $dbOTP = $check[0];				
                        if($dbOTP == $otp) {
                            return response()->json([
                                "response_code" => 200,
                                "response_message" => "OTP Verified!",
                                ],200);		
                            
                        } else {
                                    return response()->json([
                                        "response_code" => 404,
                                        "response_message" => "Incorrect OTP",
                                        ],404);		
                            
                        }					
                        
                    }	
                    
                    public function reset_password(Request $request)	
                    {
                        $email = $request->email;	
                        $password = $request->password;	
                        $updatePass = DB::table('tbl_users')->where('email', $email)->update([
							"password" => Hash::make($password)
						]);
                        if($updatePass ) {
                            return response()->json([
                                "response_code" => 200,
                                "response_message" => "Password Changed!",
                                ],200);	
                                } else {
                                    return response()->json([
                                        "response_code" => 401,
                                        "response_message" => "Some Error Occured",
                                        ],401);
                                        }
                                        }
					
					
					public function history(Request $request)
						{
							$userId = $request->userId;
							$history = DB::table('plan_history as ph')
										->join('plans', 'plans.id','=','ph.plan_id')
										->where('ph.user_id', $userId)
										->get(['plans.name','plans.image', 'plans.price','ph.valid_upto','ph.isActive']);

										// return $history;

							$countHistory = count($history);
							if($countHistory > 0) {
								return response()->json([
									"response_code" => 200,
									"response_message" => "Ok",
									"success" => $history
								], 200);
							} else {
								return response()->json([
									"response_code" => 404,
									"response_message" => "No record found",
								], 404);
							}
							
						}





						public function change_password(Request $request)
						{
							$email=$request->email;
							$oldPassword=$request->oldPassword;
							$newPassword=$request->newPassword;
			   
						$mailExist = DB::table('tbl_users')->where('email',$email)->exists();
							if($mailExist) {
								$dbPassword = $datapassword=DB::table('tbl_users')->where('email',$email)->pluck('password');
								if(Hash::check($oldPassword,$dbPassword[0])) {
									
									DB::table('tbl_users')->where('email',$email)->update([
										'password'=>Hash::make($newPassword)
									]);
									return response()->json([
										"response_code"=>200,
										"response_message"=>"Password Changed"
									], 200);
								} else {
									return response()->json([
										"response_code" => 401,
										"response_message" => "Current Password is Incorrect"
									], 401);
								}
							} else {
								return response()->json([
									"response_code"=>404,
									"response_message"=>"Mail not found"
								], 404);
							}	
							   
						}



						
		public function cancel_plan(Request $request)
		{

			$user_id= $request->user_id;
			$data=DB::table('plan_history')->where('isActive',1)->where('user_id',$user_id)->update(['isCancelled'=>1,'isActive'=>0]);
			if($data){


				DB::table('tbl_users')->where('id',$user_id)->update(['payment_status'=>0,'plan'=>null]);



				return response()->json([
					"response_code"=>200,
					"response_message"=>"Plan Cancelled Successfully"
				], 200);
			}
			else{


				return response()->json([
					"response_code"=>404,
					"response_message"=>"Some Error Occured!"
				], 404);

			}



		}




	
		public function meals(Request $request)
		{
			$user_id=$request->user_id;
			$array_result=array();

			$usercheck=DB::table('meal_plan')->where('user_id',$user_id)->count();
			if($usercheck){

			
				$user=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
				->select('meal_plan.user_id','meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
				'meal_plan.meal_6','tbl_users.name')->pluck('user_id');

				$meals=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
				->select('meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
				'meal_plan.meal_6')->get();


			 foreach($meals as $meal){
		
				$meal_1=$meal->meal_1;
				$meal_2=$meal->meal_2;
				$meal_3=$meal->meal_3;
				$meal_4=$meal->meal_4;
				$meal_5=$meal->meal_5;
				$meal_6=$meal->meal_6;			$usercheck=DB::table('meal_plan')->where('user_id',$user_id)->count();
				if($usercheck){
	
				
					$user=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
					->select('meal_plan.user_id','meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
					'meal_plan.meal_6','tbl_users.name')->pluck('user_id');
	
					$meals=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
					->select('meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
					'meal_plan.meal_6')->get();
	
	
				 foreach($meals as $meal){
			
					$meal_1=$meal->meal_1;
					$meal_2=$meal->meal_2;
					$meal_3=$meal->meal_3;
					$meal_4=$meal->meal_4;
					$meal_5=$meal->meal_5;
					$meal_6=$meal->meal_6;
					break;
				 }
	
				 $data= $meal_1.'.'.$meal_2.'.'.$meal_3.'.'.$meal_4.'.'.$meal_5.'.'.$meal_6;
				  $data_2= explode('.',$data);
	
					$obj = new \stdClass;
					$obj->user_id="$user[0]";
					$obj->head="LEAN AND MEAN (VEGGIES OPTIONAL)";
					$obj->meal=$data_2;
	
					array_push($array_result,$obj);
	
	
	
					return response()->json([
						"response_code"=>200,
						"response_message"=>"Ok",
						"success"=>$array_result
					], 200);
	
				}
	
				else{
	
					return response()->json([
						"response_code"=>404,
						"response_message"=>"You have not received any meal plan yet!"
					], 404);
	
	
				}
                break;
			 }

			 $data= $meal_1.'.'.$meal_2.'.'.$meal_3.'.'.$meal_4.'.'.$meal_5.'.'.$meal_6;
			  $data_2= explode('.',$data);

				$obj = new \stdClass;
				$obj->user_id="$user[0]";
				$obj->head="LEAN AND MEAN (VEGGIES OPTIONAL)";
				$obj->meal=$data_2;

                array_push($array_result,$obj);



				return response()->json([
					"response_code"=>200,
					"response_message"=>"Ok",
					"success"=>$array_result
				], 200);

			}

			else{

				return response()->json([
					"response_code"=>404,
					"response_message"=>"You have not received any meal plan yet!"
				], 404);


			}
	

		}


		

		public function meal_request(Request $request)
		{

			$user_id=$request->user_id;
            $today=Carbon::now()->toDateTimeString();
            $exists = DB::table('meal_request')->where('user_id',$user_id)->exists();
            if($exists) {
                DB::table('meal_request')->where('user_id',$user_id)->update(['created_at'=>$today]);
			 //   DB::table('meal_request')->insert([
			 //       "user_id"    => $userId,
			 //       "created_at" => $today
			 //   ]);
            } else {
                DB::table('meal_request')->insert([
			        "user_id"    => $user_id,
			        "created_at" => $today
			    ]);
            }
			
			$userName = DB::table('tbl_users')->where('id', $user_id)->pluck('name');

        DB::table('admin_notifications')->insert([
			"user_id" 		=> $user_id,
			"title"   		=> "Assign Meal Request",
			"description" 	=> $userName[0]." has sent meal request",
			"time"          => NOW(),
// 			"seen"			=> 0
		]);

			return response()->json([
				'response_code'=>200,
				'response_message'=>"Meal requested successfully"
			]);
		
			

		}


		public function notification(Request $request)
		{

			$user_id=$request->user_id;

			$array_result=array();

			$todayData=DB::table('monthly_checks')->where('user_id',$user_id)->whereDate('created_at',Carbon::today())->count();

			$start_date=Carbon::now();
			$end_date=Carbon::now()->addMonth(-1);
		   
			$monthData= DB::table('monthly_checks')->where('user_id',$user_id)->whereBetween('created_at',[$end_date,$start_date])->count();

			if(!$todayData && !$monthData){
				
				$obj = new \stdClass;
				$obj->notification_message="Your monthly checkin is Pending!";
				$obj->notification_image="https://th.bing.com/th/id/R.40dca51e90da0121b1b3c1b1d8512ec8?rik=q4ZKeMoIaeDlZQ&riu=http%3a%2f%2f4.bp.blogspot.com%2f-xfU8vnboL9E%2fURJoTvR3yzI%2fAAAAAAAADXU%2fhcrr2V2ZQWk%2fs1600%2fMonthly%2bUpdates.png&ehk=dQwKl7dwEo7cPpHfWifWlvqRqFIN%2bs2isxdlFhMoP40%3d&risl=&pid=ImgRaw&r=0&sres=1&sresct=1";
				$obj->time=Carbon::now()->toDateTimeString();

                array_push($array_result,$obj);

			}


			$week_end_date=Carbon::now()->addDays(-7);

			$weekTodayData=DB::table('weekly_checks')->where('user_id',$user_id)->whereDate('created_at',Carbon::today())->count();

			$weekData= DB::table('weekly_checks')->where('user_id',$user_id)->whereBetween('created_at',[$week_end_date,$start_date])->get()->count();

             if(!$weekData && !$weekTodayData){


				$obj = new \stdClass;
				$obj->notification_message="Your weekly checkin is Pending!";
				$obj->notification_image="https://th.bing.com/th/id/OIP.jY_UDpWQJ51X8neQIgIxAgAAAA?pid=ImgDet&rs=1";
				$obj->time=Carbon::now()->toDateTimeString();


                array_push($array_result,$obj);
			 }

			 $workout=DB::table('workout')->where('user_id',$user_id)->get()->count();
			 if($workout){
				$obj = new \stdClass;
				$obj->notification_message="Your workout plan has been assigned!";
				$obj->notification_image="https://cdn2.iconfinder.com/data/icons/business-v3-glyph/32/check_mark_person-256.png";
				$obj->time=Carbon::now()->toDateTimeString();
				array_push($array_result,$obj);

			 }

			 $meal_plan=DB::table('meal_plan')->where('user_id',$user_id)->get()->count();
			
			 if($meal_plan){

				$obj = new \stdClass;
				$obj->notification_message="Your Meal plan has been assigned!";
				$obj->notification_image="https://www.dollarsprout.com/wp-content/uploads/2017/09/5-dollar-meal-plan-logo-175x175.png";
				$obj->time=Carbon::now()->toDateTimeString();
				array_push($array_result,$obj);


			 }


			 $expiry=DB::table('plan_history')->where('user_id',$user_id)->where('isActive',1)->orderBy('id','desc')->first();

			 if($expiry){
			  $expiry_date=Carbon::parse($expiry->valid_upto)->diffForHumans(Carbon::now());


			 $obj = new \stdClass;
			 $obj->notification_message= $expiry_date.", Your subscription will expire";
			 $obj->notification_image="https://image.shutterstock.com/image-vector/glyph-expiry-icon-simple-solid-260nw-1915733167.jpg";
			 $obj->time=Carbon::now()->toDateTimeString();
			 array_push($array_result,$obj);

			 }


			 return response()->json([
				'response_code'=>200,
				'success'=>$array_result
			 ],200);

		}




		public function honey_option(Request $request)
		{


			$validator = Validator::make($request->all(), [ 

				'honey_option'=>'required',
	
	
			]);
	
	
	
			 if ($validator->fails()){
	
				return response()->json(
	
					[
	
						'response_code' => 401,
	
						'response_result' => $validator->errors()->first()
	
					],
	
					200
	
				);
	
			}



			$user_id=$request->user_id;

			if($user_id){

				DB::table('honey_option')->insert([

					'user_id'=>$user_id,

					'honey_option'=>$request->honey_option

				]);

				return response()->json([
					"response_code"=>200,
					"response_message"=>"Ok"
				], 200);

			}

			else{

				return response()->json([
					"response_code"=>404,
					"response_message"=>"Some error occured!"
				], 404);

			}



		}


		public function body_stats_ios(Request $request)
		{



			// $data1=DB::table('monthly_checks')->where('user_id',$user_id)->select('weight',DB::raw("MONTHNAME(created_at) as monthname"))
			// ->whereYear('created_at', date('Y'))
			// ->get('weight');


			$main = array();

			// Weight

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('weight as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('weight as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Weight";
			$weightObj->data = $weight;

			array_push($main,$weightObj);

			// Waist

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('waist as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('waist as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Waist";
			$weightObj->data = $weight;

			array_push($main,$weightObj);

            // Left Arm

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('left_arm as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('left_arm as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Left Arm";
			$weightObj->data = $weight;

			array_push($main,$weightObj);
           
			// Right Arm
			

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('right_arm as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('right_arm as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Right Arm";
			$weightObj->data = $weight;

			array_push($main,$weightObj);

			// Left Quad

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('left_quad as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('left_quad as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Left Quad";
			$weightObj->data = $weight;

			array_push($main,$weightObj);

			// Right Quad

			$weight = DB::table('monthly_checks')->where('user_id', $request->user_id)
			->select('right_quad as weightText',DB::raw("MONTHNAME(created_at) as monthname"))
			->whereYear('created_at', date('Y'))
			->get('right_quad as weightText');
			
			$weightObj= new \stdClass;
			$weightObj->stat = "Right Quad";
			$weightObj->data = $weight;

			array_push($main,$weightObj);

			
			return response()->json([
				"Body_Stats" => $main,
				// "Waist" => $ques2_array,
				// "Arms" => $ques3_array,
				// "Quads" => $ques4_array,
				// "page5" => $page5,
				"response_code" => 200,
				"response_message" => "Ok"
			], 200);


		}


		public function workout_ios(Request $request)
		{

			
			$user_id=$request->user_id;

	
           $result_array = array();

		//    Biceps/Triceps

		   $data1=DB::table('workout')->where('user_id',$user_id)->where('category',"biceps/triceps")->select('exercise','sets','reps')->get();

            $obj = new \stdClass;
			$obj->id=1;
			$obj->part="BICEPS/TRICEPS";
            $obj->data = $data1;
            array_push($result_array, $obj);

			// Shoulders
        

		   $data2=DB::table('workout')->where('user_id',$user_id)->where('category',"shoulders")->select('exercise','sets','reps')->get();

            $obj = new \stdClass;
			$obj->id=2;
			$obj->part="SHOULDERS";
            $obj->data = $data2;
            array_push($result_array, $obj);

			// Back


		   $data3=DB::table('workout')->where('user_id',$user_id)->where('category',"back")->select('exercise','sets','reps')->get();

            $obj = new \stdClass;
			$obj->id=3;
			$obj->part="BACK";
            $obj->data = $data3;
            array_push($result_array, $obj);

			// Chest/Calves/Abs

			$data4=DB::table('workout')->where('user_id',$user_id)->where('category',"chest/calves/abs")->select('exercise','sets','reps')->get();

            $obj = new \stdClass;
			$obj->id=4;
			$obj->part="CHEST/CALVES/ABS";
            $obj->data = $data4;
            array_push($result_array, $obj);

			// Legs

			$data5=DB::table('workout')->where('user_id',$user_id)->where('category',"legs")->select('exercise','sets','reps')->get();

            $obj = new \stdClass;
			$obj->id=5;
			$obj->part="LEGS";
            $obj->data = $data5;
            array_push($result_array, $obj);
        

       
  
        return response()->json([
            "Workout" => $result_array,
            "response_code" => 200,
            "response_message" => "Ok"
        ], 200);



		}


		public function meals_ios(Request $request)
		{
			$user_id=$request->user_id;

			$usercheck=DB::table('meal_plan')->where('user_id',$user_id)->count();

			if($usercheck){

			
				$user=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
				->select('meal_plan.user_id','meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
				'meal_plan.meal_6','tbl_users.name')->pluck('user_id');

				$meals=DB::table('meal_plan')->where('user_id',$user_id)->join('tbl_users','meal_plan.user_id','=','tbl_users.id')
				->select('meal_plan.meal_1','meal_plan.meal_2','meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5',
				'meal_plan.meal_6')->get();

				return meals;

			 foreach($meals as $meal){
		
				$meal_1=$meal->meal_1;
				$meal_2=$meal->meal_2;
				$meal_3=$meal->meal_3;
				$meal_4=$meal->meal_4;
				$meal_5=$meal->meal_5;
				$meal_6=$meal->meal_6;
                break;
			 }

			 $data= $meal_1.'.'.$meal_2.'.'.$meal_3.'.'.$meal_4.'.'.$meal_5.'.'.$meal_6;
			  $data_2= explode('.',$data);

				$obj = new \stdClass;
				$obj->user_id="$user[0]";
				$obj->head="LEAN AND MEAN (VEGGIES OPTIONAL)";
				$obj->meal=$data_2;

                array_push($array_result,$obj);



				return response()->json([
					"response_code"=>200,
					"response_message"=>"Ok",
					"success"=>$array_result
				], 200);

			}

			else{

				return response()->json([
					"response_code"=>404,
					"response_message"=>"You have not received any meal plan yet!"
				], 404);


			}



		}


		public function current_shot(Request $request)
		{

			$user_id=$request->user_id;

			$current_shot=DB::table('tbl_users')->where('id',$user_id)->first('current_shot');

			if($current_shot){

				return response()->json([
					'response_code'=>200,
					'response_message'=>'Ok',
					'success'=>$current_shot

				],200);


			}
			else{

				return response()->json([
					'response_code'=>401,
					'response_message'=>'Network Error',
				],401);

			}

		}
		

// 		public function old_shot(Request $request)
// 		{
// 			$user_id=$request->user_id;

// 			$old_shot=DB::table('tbl_users')->where('user_id',$user_id)->orderBy('id','asc')->first('frontshot');

// 			if($old_shot){

// 				return response()->json([
// 					'response_code'=>200,
// 					'response_message'=>'Ok',
// 					'success'=>$old_shot

// 				],200);


// 			}
// 			else{

// 				return response()->json([
// 					'response_code'=>401,
// 					'response_message'=>'Network Error',
// 				],401);

// 			}



// 		}


public function old_shot(Request $request)
{
    
    $user_id=$request->user_id;
    $old_shot = DB::table('tbl_users')
        ->where('id', $user_id)
        ->orderBy('id', 'asc')
        ->first('frontshot');

    if ($old_shot) {
        return response()->json([
            'response_code' => 200,
            'response_message' => 'Ok',
            'success' => $old_shot
        ], 200);
    } else {
        return response()->json([
            'response_code' => 401,
            'response_message' => 'Network Error',
        ], 401);
    }
}



		public function payment_status(Request $request)

		{
			$user_id=$request->user_id;

			$status=DB::table('plan_history')->where('user_id',$user_id)->where('isActive',1)->get()->count();
			if($status){
				return response()->json([
					'response_code'=>200,
					'response_message'=>'ok',
				],200);
			}

			else{

				return response()->json([
					'response_code'=>401,
					'response_message'=>'No Plan found!',
				],401);

			}

			
		}


		public function delete_account(Request $request)
		{
			$user_id=$request->user_id;

			$user_delete=DB::table('tbl_users')->where('id',$user_id)->update([
				'isActive'=>0
			]);

			if($user_delete)
			{
				return response()->json([
					'response_code'=>200,
					'response_message'=>'Account deleted successfully!',
				],200);
			}

			else{

				return response()->json([
					'response_code'=>500,
					'response_message'=>'Some error occured!',
				],500);

			}


		}
		
		 public function update(Request $request)
    {
        // dd($request);
        $request->validate([
            'userId' => 'required',
            'fcmToken' => 'required',
        ]);

        // Update the FCM token for the user
        try {
            DB::table('tbl_users')
                ->where('id', $request->userId)
                ->update(['fcm_token' => $request->fcmToken]);

           return response()->json([
					'response_code'=>200,
					'response_message'=>'FCM Token Updated successfully!',
				],200);
        } catch (\Exception $e) {
            	return response()->json([
					'response_code'=>500,
					'response_message'=>'Some error occured!',
				],500);

        }
    }


}

