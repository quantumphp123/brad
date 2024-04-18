<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Professional;
use App\Models\Videos;
use App\Models\Moreimages;
use App\Models\Skill;
use App\Models\Plan;
use Session;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Post;
use App\Exports\PostExport;
use DB;
use Mail;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Services\FCMService;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }
    
    public function privacy_policy()
    {
        return view('privacyPolicy');
    }
    
    public function terms_and_condition()
    {
        return view('terms_and_condition');
    }
    
	
	public function basic_email() {
      $data = array('name'=>"Virat Gandhi");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('saifthegame0001@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('saif.quantum@gmail.com','saif khan');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
   public function html_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('saif.quantum@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
	
	
	
	public function login_post(Request $request)
	{
	$credentials = $request->only('email','password');
	// return $credentials;
	// $checkEmail = DB::table('users')->where(['email'=>$request->email])->first();
	// if( !$checkEmail || !Hash::check($request->password , $checkEmail->password)) {
	// 	return "im here";
	// 	return back()->with('err_msg', 'Invalid Email or Password');
	// } else {
	// 	return "im not here";

	// 	session()->put('admin-login-id', $checkEmail->id);
	// 	// return redirect()->route('admin.dashboard');
	// 	return redirect(url('admin-dashboard'));
	// }
	// $checkAdmin = User::where('email', $request->email)->where('password', Hash::make($request->password))->exists();
	// 	return $checkAdmin;
	// if($checkAdmin) {
	// 		return "yayy";
	// 	}
	// session()->put('admin-login-id',$useLoginId[0]->id);
	return redirect(url('admin-dashboard'));
	if (Auth::attempt($credentials)) {
		if(Auth::user()->role_id == 1){
			$useLoginId=User::where(['email'=>$request->email])->get();
			session()->put('admin-login-id',$useLoginId[0]->id);
			return redirect(url('admin-dashboard'));

		} else {
			Session::flush();
			Auth::logout();
			\Session::put('err_msg','Invalid Username and Password.');
			//return redirect(url('admin-login'));

			return redirect()->route('admin-login');
		}
	} else {
		\Session::put('err_msg','Invalid Username and Password.');
		return redirect(url('admin-login'));
		}
	}

   
	public function admin_dashboard()
    {
		$data['workout']=count(DB::table('workout')->join('tbl_users','workout.user_id','=','tbl_users.id')->select('workout.user_id')->distinct()->get());
        $data['videos']=count(Videos::all());
		$data['users']=count(DB::table('tbl_users')->get());
		$data['plans']=count(Plan::all());
		$data['subscription']=count(DB::table('plan_history')->join('tbl_users','plan_history.user_id','=','tbl_users.id')
		->join('plans','plan_history.plan_id','=','plans.id')
		->select('plan_history.user_id','tbl_users.name','plans.name as plan_name')->get());
		// return $data;
		return view('admin.dashboard',$data);
    }
	
	public function professional()
    {
		$data=DB::table('tbl_users')->select('tbl_users.id','tbl_users.name','tbl_users.email','tbl_users.contact','tbl_users.payment_status','tbl_users.gender','tbl_users.created_at','tbl_users.isActive')->orderby('tbl_users.id','desc')->get();
		return view('admin.professional.index',compact('data'));
    } 
	
	
	
	public function ExportProfessional()
  {
    return Excel::download(new PostExport, 'Professional.xlsx');
  }
	
	public function add_professional()
    {
       return view('admin.professional.add');
    }
	

	public function post_add_professional(Request $request)
	{





	 $request->validate([
	 'name'=>'required|max:100|min:0',
	 'email'=>'required|email|max:30|min:0|unique:tbl_users,email',
	 'contact' => 'required|unique:tbl_users,contact',
	 'password' => 'required|max:20|min:8',
	 'dob' => 'required|date',
	 ]);





		// $length = 50;

		// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		// $charactersLength = strlen($characters);

		// $randomString = '';

		// for ($i = 0; $i < $length; $i++) {

		// $randomString .= $characters[rand(0, $charactersLength - 1)];

		// }

		// $randomString;



		   $id=DB::table('tbl_users')-> insertGetId(array(

			'name'=>$request->name,

			'email'=>$request->email,

			'contact'=>$request->contact,

			'password'=>Hash::make($request->password),

			'dob'=>$request->dob,

			'payment_status'=>0,

			'token'=>$request->token

		   )
		);

		DB::table('plan_history')->insert([

			'user_id'=>$id,
			'plan_id'=>0,
			'isActive'=>0,
			'isCancelled'=>0

		]);




			\Session::put('success','User Added Successfully');
			return redirect('professional');



	 }



	
	// public function post_add_professional(Request $request)
	
	// {

	// $validator = Validator::make($request->all(), [
	// 'name'=>'required|max:100|min:0',
	// 'mobile'=>'required|max:10|min:0|unique:professionals',
	// 'email' => 'required|email|max:100|min:0|unique:professionals',
	// 'password' => 'required|max:100|min:0',
	// 'address' => 'required|max:100|min:0',
	// //'file' => 'required|mimes:jpg,jpeg,png,svg|max:2048',
	// ]);

	// if($validator->fails()){
	// return redirect()->back()
	// ->withErrors($validator)
	// ->withInput();
	// }

	// if($request->skill==""){
	// 	\Session::put('success','Please select at least one Skill');
	// 	return redirect()->route('student-list');
	// }
	
	
	// $rand = mt_rand(1500, 5000);
	// $professional_id_code = 'PDI-'.$rand;
	
	// $length = 50;
	// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	// $charactersLength = strlen($characters);
	// $randomString = '';
	// for ($i = 0; $i < $length; $i++) {
	// $randomString .= $characters[rand(0, $charactersLength - 1)];
	// }
	// $randomString;
	
	
	// $userprofile=new Professional;
	
	
	// if($request->file('file')){
	// $imageName = time().'.'.$request->file->extension();
	// $request->file->move(public_path('uploads/professional'),$imageName);
	// $userprofile->image=url('public/uploads/professional').'/'.$imageName;
	// }else{
	// $userprofile->image=url('public/uploads/professional/dummy.jpeg'); 
	// } 
 
 
	// $userprofile->name=$request->name;
	// $userprofile->professional_id=$professional_id_code;
	// $userprofile->remember_token=$randomString;
	// $userprofile->email=$request->email;
	// $userprofile->mobile=$request->mobile;
	// $userprofile->password=$request->password;
	// $userprofile->address=$request->address;
	// $userprofile->status='0';
	// $userprofile->save();
	// $professional_id = $userprofile->id;



	// if($request->skill){
	// for($i=0;$i<count($request->skill);$i++){
	// $instrument=new Skill;
	// $instrument->professional_id=$professional_id;
	// $instrument->skill=$request->skill[$i];
	// $instrument->save();
	//   }
	// }

	// \Session::put('success','Data Added Successfully.');
	// return redirect()->route('professional');

	// }
	
	
	function add_more_images(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
	
	//'proffessional_id'=>'required|max:10|min:0|exists:professionals',
	
	]);

	if($validator->fails()){
	return redirect()->back()
	->withErrors($validator)
	->withInput();
	}
		
		$proff_id = $request->proff_id;
		 if($request->file('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                 $name = time().rand(1,50).'.'.$file->extension();
                $file->move(public_path('uploads/professional'), $name);  
                $files[] = $name;  
				
				$userprofile_image=url('public/uploads/professional').'/'.$name;
			   
			   DB::table('proff_images')->insert(
			array(
			'proffessional_id'=>$proff_id,
			'status'=>0,
			'image'=>$userprofile_image
			));
            }
			\Session::put('success','Images Uploaded.');
			 return redirect("view-professional/$proff_id");
         }else{
			 \Session::put('success','Please Select Atleast One Image.');
			 return redirect("view-professional/$proff_id");
		 }
		
		
		
	}
	
	function update_proffessional_status(Request $request)
	{
		
		$proffstatus = $request->proffstatus;
		$id = $request->col_id;
		
		
		$userprofile=Moreimages::find($id);
		
		if($userprofile->status==0){
			$userprofile->status=1;
		$userprofile->save();
	    echo '<span id="status_pending<?php echo $orderDetails->id; ?>" class="badge badge-info">approved</span>';		
		exit();
		}
		
		if($userprofile->status==1){
			$userprofile->status=0;
		$userprofile->save();
			echo '<span id="status_approved<?php echo $orderDetails->id; ?>" class="badge badge-warning">pending</span>';
		exit();
		}
		
	
	}
	
	
	function delete_more_images($id)
	{
		
	$result = DB::table('proff_images')->where('id',$id)->get();
	$proff_id = $result[0]->proffessional_id;
	$result[0]->image;
	$string_no =  strpos($result[0]->image,"public");
	$new_image = substr($result[0]->image,$string_no);
	$str = $result[0]->image;
	$storage =  unlink($new_image);
    if($storage){
		
	Moreimages::where('id',$id)->delete();
	\Session::put('success','File deleted successfully');
	return redirect("view-professional/$proff_id");
		
	}else{
		\Session::put('success','Something went wrong');
	return redirect("view-professional/$proff_id");
	}   
	
		
	}
	
	
	
	function proff_update(Request $request)
	{
		
	 $id = $request->proff_id;
	
	//$userprofile=new Professional;
	$userprofile=Professional::find($id);
	$userprofile->name=$request->name;
	$userprofile->email=$request->email;
	$userprofile->mobile=$request->mobile;
	$userprofile->password=$request->password;
	$userprofile->address=$request->address;
	$userprofile->save();
	\Session::put('success','Data Updated Successfully.');
	return redirect("view-professional/$id");
	
	}
	
	
	
	public function delete_professional($id)
    {
		DB::delete('delete from tbl_users where id = ?',[$id]);
		\Session::put('success','User Deleted Successfully.');
	   return redirect()->route('professional');
	}
	
	public function change_status(Request $request)
	{
		$status = $request->status;
		 $id = $request->proff_id;
			
		if($status=='0'){
		$res=Professional::find($id);
		$res->status='1';
		$res->save();
		}else{
		$res=Professional::find($id);
		$res->status='0';
		$res->save();
		}
		
	}
	
	
	public function view_professional($id)
    {
		$data['info'] = DB::table('tbl_users')->where('tbl_users.id',$id)->get();
		$plan_id= $data['info'][0]->plan;
		if($plan_id==null){

			$plan_name=null;
			$data= DB::table('tbl_users')->where('tbl_users.id',$id)->get();

			return view('admin.professional.detail',['user'=>$data,'plan'=>$plan_name]);
		}
		else{

			$data= DB::table('tbl_users')->where('tbl_users.id',$id)->get();
			$plan_exist= $data[0]->plan;
            $plan_name=DB::table('plans')->where('plans.id',$plan_exist)->get('name');

			return view('admin.professional.detail',['user'=>$data,'plan'=>$plan_name]);

		}
	}	
	
	public function delete_skill($id,$userId)
    {
		Skill::destroy($id);
		\Session::put('success','Data Deleted Successfully.');
	   return redirect("view-professional/$userId");
	}
	
	
	
	public function add_skill(Request $request)
	
	{
		
		$id = $request->proff_id;
     if($request->skill==""){
		\Session::put('success','Please select at least one instrument');
		return redirect("view-professional/$id");
	}
    
	if($request->skill){
	for($i=0;$i<count($request->skill);$i++){
	$instrument=new Skill;
	$instrument->professional_id=$request->proff_id;
	$instrument->skill=$request->skill[$i];
	$instrument->save();
	  }
	}

	\Session::put('success','Data Added Successfully.');
	return redirect("view-professional/$id");

	}
	
	
	public function estimate()
    {
       return view('admin.estimate.index');
    }
	
	public function add_estimate()
    {
       return view('admin.estimate.add');
    }
	
	
	
	public function videos()
    {
		$data['Videos']=Videos::orderby('id','desc')->get();
       return view('admin.videos.index',$data);
    }
	
	
	public function add_videos()
    {
       return view('admin.videos.add');
    }
	
	
	
	public function post_add_videos(Request $request)
	
	{
		
		
		

	$validator = Validator::make($request->all(), [
	'title'=>'required|max:100|min:0',
	'description'=>'required|max:10|min:0',
	'video_link' => 'required|max:100|min:0',
	//'file' => 'required|mimes:jpg,jpeg,png,svg|max:2048',
	]);

	if($validator->fails()){
	return redirect()->back()
	->withErrors($validator)
	->withInput();
	}

	$userprofile=new Videos;
	
	
	if($request->file('file')){
	$imageName = time().'.'.$request->file->extension();
	$request->file->move(public_path('uploads/professional'),$imageName);
	$userprofile->image=url('public/uploads/professional').'/'.$imageName;
	}else{
	$userprofile->image=url('public/uploads/professional/dummy.jpeg'); 
	} 
 
 
	$userprofile->title=$request->title;
	$userprofile->description=$request->description;
	$userprofile->video_link=$request->video_link;
	$userprofile->status='0';
	$userprofile->save();
	

	\Session::put('success','Data Added Successfully.');
	return redirect()->route('videos');

	}
	

	public function delete_video($id)
	{
		DB::delete('delete from videos where id = ?',[$id]);

		\Session::put('success','Video Deleted Successfully.');
	    return redirect()->route('videos');


	}
	
	
	public function logout()
	{
	Auth::logout();
	Session::flush();
	return redirect(url('admin-login'));
	}

	public function plans()
    {
		$data['plans']=Plan::select('id','image','name','price','validity')->orderby('id','desc')->get();
        //dd($data);
       return view('admin.Plans.index',$data);
    }


    public function add_plans()
    {
       return view('admin.Plans.add');
    }

    public function post_add_plans(Request $request)

	{

	$validator = Validator::make($request->all(), [
	'title'=>'required|max:100|min:0',
	'price'=>'required|max:10|min:0',
	'validity' => 'required',
	'file' => 'required',
	]);

	if($validator->fails()){
	return redirect()->back()
	->withErrors($validator)
	->withInput();
	}

	$plan=new Plan;


	if($request->file('file')){
	$imageName = time().'.'.$request->file->extension();
	$request->file->move(public_path('uploads/plans'),$imageName);
	$plan->image=url('public/uploads/plans').'/'.$imageName;
    //$plan->image=$imageName ;
	}

	$plan->name=$request->title;
	$plan->price=$request->price;
	$plan->validity=$request->validity;
	$plan->status='0';
	$plan->save();


	\Session::put('success','Data Added Successfully.');
	return redirect('plans');

	}

    public function change_plan_status(Request $request)
	{
		$status = $request->status;
		 $id = $request->plan_id;

		if($status=='0'){
		$res=Plan::find($id);
		$res->status='1';
		$res->save();
		}else{
		$res=Plan::find($id);
		$res->status='0';
		$res->save();
		}

	}



	public function edit_plan($id){
		$data=Plan::find($id);
		return response()->json($data);
   }
   
   
   public function update_plan(Request $req)
   {
	   $plan_id=$req->input('plan_id');
	   $plan=Plan::find($plan_id);
	   $plan->name=$req->plan_name;
	   $plan->price=$req->plan_price;
	   $plan->update();

	   \Session::put('success','Plan Updated Successfully.');
		return redirect('plans');

   }
       






    public function delete_plan($id)
    {

        $plan=Plan::find($id);

            //$image=$plan->image;
            //if ($image) {
            //$string_no =  strpos($image,"public");
            //$new_image = substr($image,$string_no);
            //unlink($new_image);
          // }
		$plan->delete();

		\Session::put('success','Data Deleted Successfully.');
        return redirect('plans');

	}
	
	public function plan_payment($planId,$userId)
    {
	
		$data['planId'] = $planId;
		$data['userId'] = $userId;
		
		return view('admin.payment',$data);
		
		

	}
	
	
	public function userPayment(Request $request)
	{
	    $planid = $request->planid;
		$userId = $request->userId;
		
		$plans = DB::table('plans')->where('id',$planid)->exists();
		if(!$plans){
			echo 'Plan Does Not Exist';
			exit();
		}
		
		$user = DB::table('tbl_users')->where('id',$userId)->exists();
		if(!$user){
			echo 'user Does Not Exist';
			exit();
		}
		
		$update = DB::table('tbl_users')->where('id',$userId)->update(
		array('plan'=>$planid, 'payment_status' => 1));
		
		$insertHistory = DB::table('plan_history')->create([
			"user_id" => $userId,
			"plan_id" => $planid,
		]) ;
		
		
		if($update){
		 return redirect()->route('paymentSuccessfull');
		}else{
			echo 'Network Issue';
		}
		
	}
	
	public function paymentSuccessfull(Request $request)
	{
	   return view('admin.paymentSuccessfull');
		
	}
	
	
	
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


	public function weekly_check()
	{
		$events=array();
		$weeks=DB::table('weekly_checks')->join('tbl_users','weekly_checks.user_id','=','tbl_users.id')
		->select('weekly_checks.user_id','tbl_users.name','weekly_checks.created_at')->orderBy('weekly_checks.id','desc')->get();
		foreach($weeks as $week){
			$events[]=[
                    'id'=>$week->user_id,
                   'title'=>$week->name,
                   'start'=>$week->created_at,
     			   'allday'=>true,
			];
		}



		$users=DB::table('weekly_checks')->join('tbl_users','weekly_checks.user_id','tbl_users.id')
		->select('weekly_checks.user_id','tbl_users.name')->get()->unique('user_id');


		return view('admin.weekly_check.weekly_check',['week_data'=>$events,'users'=>$users]);
	}


	public function show_user_weekly($id)
	{
		$weekData=DB::table('weekly_checks')->where('user_id',$id)->join('tbl_users','weekly_checks.user_id','=','tbl_users.id')
		->select('tbl_users.email','tbl_users.name','weekly_checks.user_id','weekly_checks.front_shot','weekly_checks.back_shot',
		'weekly_checks.comments','weekly_checks.question','weekly_checks.created_at')->orderBy('weekly_checks.created_at','desc')->get();


		return view('admin.weekly_check.show_user_weekly',['data'=>$weekData]);
	}


	



	public function monthly_check()
	{
		$events=array();
		$months=DB::table('monthly_checks')->join('tbl_users','monthly_checks.user_id','=','tbl_users.id')
		->select('monthly_checks.user_id','tbl_users.name','monthly_checks.created_at')
		->orderBy('monthly_checks.id','desc')->get();
		foreach($months as $month){
			$events[]=[
                     'id'=>$month->user_id,
                   'title'=>$month->name,
                   'start'=>$month->created_at,
     			   'allday'=>true,
				];
		}


		return view('admin.monthly_check.monthly_check',['month_data'=>$events]);
	}


	public function show_user_monthly($id)
	{
		$monthData=DB::table('monthly_checks')->where('user_id',$id)->join('tbl_users','monthly_checks.user_id','=','tbl_users.id')
		->select('tbl_users.email','tbl_users.name','monthly_checks.user_id','monthly_checks.front_shot','monthly_checks.back_shot',
		'monthly_checks.comments','monthly_checks.question','monthly_checks.created_at','monthly_checks.weight',
		'monthly_checks.waist','monthly_checks.left_arm','monthly_checks.right_arm','monthly_checks.left_quad',
		'monthly_checks.right_quad')->orderBy('monthly_checks.created_at','desc')->get();
		return view('admin.monthly_check.show_user_monthly',['data'=>$monthData]);
	}


	public function workout()
	{
		$users = DB::table('workout')->groupBy('user_id')->pluck('user_id');
		$name =  DB::table('tbl_users')->whereIn('id',$users)->orderBy('id','desc')->get(['id','name']);

		return view('admin.workout.index',['name'=>$name]);
	}

	public function add_workout()
	{
		$users=DB::table('tbl_users')->select('id','name','email')->orderBy('id','desc')->get();
		$category=DB::table('exercise_category')->get();
		return view('admin.workout.add_workout',compact('users','category'));
	}


	public function get_exercises($id)
	{
		// $id=DB::table('exercise_category')->where('category',$category)->pluck('id');
		// return $id;
		$exercise=DB::table('exercise')->where('category_id',$id)->get();
		return response()->json($exercise);
	}



	public function add_exercise()
	{
		$exercise_category=DB::table('exercise_category')->get();
		return view('admin.workout.add_exercise',compact('exercise_category'));
	}


	public function post_add_exercise(Request $request)
	{
		       $category=$request->category;
	           $exercise=$request->exercise;


			   $check=DB::table('exercise')->where('exercise_name',$exercise)->where('category_id',$category)->get()->count();
			   if($check>=1){
				  \Session::put('failed','This exercise of above category is already added');
				  return back();
			   }

			   else{

				DB::table('exercise')->insert([
					'exercise_name'=>$exercise,
					'category_id'=>$category
				]);

				\Session::put('success','Exercise Added...');
				return back();



			   }
	}


	public function show_exercises()
	{
		$exercises=DB::table('exercise')->join('exercise_category','exercise.category_id','=','exercise_category.id')
		->get(['exercise.id','exercise.exercise_name','exercise_category.category']);
		return view('admin.workout.show_exercises',['exercises'=>$exercises]);
	}
	
	public function delete_added_exercise($id)
	{
		DB::table('exercise')->where('id',$id)->delete();

		\Session::put('success','Exercise Deleted Successfully...');
				return back();
		
	}

	public function post_update_exercise(Request $request)
	{
		  DB::table('exercise')->where('id',$request->id)->update([
			'exercise_name'=>$request->exercise,
		  ]);

		  \Session::put('success','Exercise Updated Successfully...');
		  return back();

	}


	public function post_add_workout(Request $request)
	{

		$id=$request->category;
		$users=$request->user_id;
		
		$category_name=DB::table('exercise_category')->where('id',$id)->get('category');
        $category=$category_name[0]->category;

		for($i=0;$i<count($users);$i++){

	
				DB::table('workout')->insert([

					'user_id'=>$users[$i],
					'category'=>$category,
					'exercise'=>$request->exercise,
					'sets'=>$request->sets,
					'reps'=>$request->reps
	
				]);


		
		}


				\Session::put('success','Workout Added Successfully.');
	  			return redirect()->route('admin-workout');

	  

	}



	public function user_workout($id) 
	{
		$user=DB::table('workout')->join('tbl_users','workout.user_id','=','tbl_users.id')->where('user_id',$id)->get(['name']);
		$category=array();
		$exercise=array();
		$exercise_id=array();
		$data = DB::table('workout')->where('user_id', $id)->get();
		foreach($data as $item){
			$category[]=$item->category;
			$exercise[]=$item->exercise;
            $exercise_id[]=$item->id;
		}
		
		$sets=DB::table('workout')->where('user_id',$id)->get('sets');
		$reps=DB::table('workout')->where('user_id',$id)->get('reps');


		return view('admin.workout.show_workout',compact('category','exercise','user','sets','reps','exercise_id'));
	}


	public function delete_workout($id)
	{
		DB::delete('delete from workout where user_id = ?',[$id]);
		
	\Session::put('success','Workout Deleted Successfully.');
	return back();
		  
	}




	public function delete_exercise($id)
	{

		DB::table('workout')->where('id',$id)->delete();
		
		\Session::put('success','Exercise Category Deleted Successfully.');
		return back();
			  

	}



	public function meals()

	{
		$data=DB::table('meal_plan')->join('tbl_users','meal_plan.user_id','tbl_users.id')->select('meal_plan.id','meal_plan.meal_1','meal_plan.meal_2',
		'meal_plan.meal_3','meal_plan.meal_4','meal_plan.meal_5','meal_plan.meal_6','tbl_users.name','tbl_users.email')->orderBy('meal_plan.id','desc')->get();
		return view('admin.meals.index',compact('data'));
	}
	
	public function add_meals()
	{
		$users=DB::table('tbl_users')->where('isActive',1)->orderBy('id','desc')->get();
		
		return view('admin.meals.add_meals',['users'=>$users]);
	}

	public function user_questions(Request $request)
	{
// 		return $request->all();
		$valid = Validator::make($request->all(), [
	        "user_id" => "exists:question_solution,user_id"
	    ], [
	        "user_id.exists" => "User has not Submitted answer to any questions"
	        ]);
	        
	        if($valid->fails()){
	            return back()->withErrors($valid);
	        }
	
		$user_id=$request->user_id;



        $questions=DB::table('questions')->get('question');
	

		$answers=DB::table('question_solution')->where('user_id',$user_id)->leftJoin('options','question_solution.option_id','=','options.id')
		->select('question_solution.question_id','options.options','question_solution.text')->get();

// return $answers;


		$answer_array=array();
		 $answer1='';
		 $answer2='';
		 $answer3='';
		 $answer4='';
		 $answer5='';
         $answer6='';
         $answer7='';
         $answer8='';
         $answer9='';
         $answer10='';
         $answer11='';
         $answer12='';
         $answer13='';
         $answer14='';
         $answer15='';
         $answer16='';

		foreach($answers as $answer)
		{
             if($answer->question_id==1){
				$answer1=$answer1.$answer->options;
			 }
             else if($answer->question_id==2){
				$answer2=$answer2.$answer->options;
			 }
             else if($answer->question_id==3){
				$answer3=$answer3.$answer->options;
			 }
             else if($answer->question_id==4){
				$answer4=$answer4.$answer->options;
			 }

			else if($answer->question_id==5){
				$answer5=$answer5.$answer->options.'</br>';
			}
			else if($answer->question_id==6){
				$answer6=$answer6.$answer->options.'</br>';
			
			}
			else if($answer->question_id==7){
				$answer7=$answer7.$answer->options.'</br>';
			
			}
			else if($answer->question_id==8){
				$answer8=$answer8.$answer->options.'</br>';
			}
			else if($answer->question_id==9){
				$answer9=$answer9.$answer->options.'</br>';
			
			}
			else if($answer->question_id==10){
				$answer10=$answer10.$answer->options.'</br>';
			
			}
			else if($answer->question_id==11){
				$answer11=$answer11.$answer->options.'</br>';
			
			}
			else if($answer->question_id==12){
				$answer12=$answer12.$answer->options.'</br>';
			
			}
			else if($answer->question_id==13){
				$answer13=$answer13.$answer->options.'</br>';
			
			}
			else if($answer->question_id==14){
				$answer14=$answer14.$answer->text;
			
			}
			else if($answer->question_id==15){
				$answer15=$answer15.$answer->text;
			
			}
			else if($answer->question_id==16){
				$answer16=$answer16.$answer->text;
			
			}

		}

		array_push($answer_array,$answer1,$answer2,$answer3,$answer4,$answer5,$answer6,$answer7,$answer8,$answer9,$answer10,$answer11,$answer12,$answer13,$answer14,$answer15,$answer16);
        // return $answer_array[1];

			
		$options=DB::table('question_solution')->where('user_id',$user_id)->leftJoin('options','question_solution.option_id','=','options.id')
		->where('options.page_no','>=','2')
		->select('options.options')->get()->unique('options');
    // return $options;

		$honey_option=DB::table('honey_option')->where('user_id',$user_id)->get('honey_option');
// 		return $honey_option;

		$username=DB::table('tbl_users')->where('id',$user_id)->select('id','name','email')->get();
// 		return $username[0]->id;
            // return $honey_option;
            // return [
            //     'questions'   => $questions,
            //     'honeyOption' => $honey_option,
            //     'answers'     => $answer_array,
            //     'username'    => $username,
            //     'options'     => $options
            //     ];
		 return view('admin.meals.user_questions',compact('questions','honey_option','answer_array','username','options'));




	}



	public function meal_quantity(Request $request)
	{

		// return $request->all();
		$user_id=$request->user_id;
		$meal_1=$request->meal1;
		$meal_2=$request->meal2;
		$meal_3=$request->meal3;
		$meal_4=$request->meal4;
		$meal_5=$request->meal5;
		$meal_6=$request->meal6;


		return view('admin.meals.add_quantity',compact('user_id','meal_1','meal_2','meal_3','meal_4','meal_5','meal_6'));



	}



	




	public function post_add_meals(Request $request)
	{

		// return $request->all();
	 $user_id= $request->user_id;


     $meal1=array();	

     for($i=0;$i<count($request->meal_1);$i++){


		$meal1[]=$request->meal_1[$i].' ('.$request->meal_1_quantity[$i].')';

		}


    $meal2=array();	

     for($i=0;$i<count($request->meal_2);$i++){


		$meal2[]=$request->meal_2[$i].' ('.$request->meal_2_quantity[$i].')';

		}




     $meal3=array();	

     for($i=0;$i<count($request->meal_3);$i++){


		$meal3[]=$request->meal_3[$i].' ('.$request->meal_3_quantity[$i].')';

		}



     $meal4=array();	

     for($i=0;$i<count($request->meal_4);$i++){


		$meal4[]=$request->meal_4[$i].' ('.$request->meal_4_quantity[$i].')';

		}

		  

		if(!($request->meal_5==0)){

			$meal5=array();	
	
			for($i=0;$i<count($request->meal_5);$i++){
	
	
			$meal5[]=$request->meal_5[$i].' ('.$request->meal_5_quantity[$i].')';
	
			}
		}
	
		else{
			$meal5=array();
		}
	
	
			if(!$request->meal_6==0){
	
		 
		 $meal6=array();	
	
		 for($i=0;$i<count($request->meal_6);$i++){
	
	
			$meal6[]=$request->meal_6[$i].' ('.$request->meal_6_quantity[$i].')';
	
			}
	
		}
	
		else{
			$meal6=array();
		}


	 
	       $user_id=$request->user_id;
           $user_check=DB::table('meal_plan')->where('user_id',$user_id)->get()->count();

			if(!$user_check){

	              DB::table('meal_plan')->insert([

					'user_id'=>$user_id,
                    'meal_1'=>implode(' , ' ,$meal1), 
                    'meal_2'=>implode(' , ' ,$meal2), 
                    'meal_3'=>implode(' , ' ,$meal3), 
                    'meal_4'=>implode(' , ' ,$meal4), 
                    'meal_5'=>implode(' , ' ,$meal5), 
                    'meal_6'=>implode(' , ' ,$meal6),

				  ]);


					\Session::put('success','Successfully assigned meal to this user!');
					return redirect('meals');

			}
			else{


				DB::table('meal_plan')->where('user_id',$user_id)->update([

                    'meal_1'=>implode(' , ' ,$meal1), 
                    'meal_2'=>implode(' , ' ,$meal2), 
                    'meal_3'=>implode(' , ' ,$meal3), 
                    'meal_4'=>implode(' , ' ,$meal4), 
                    'meal_5'=>implode(' , ' ,$meal5), 
                    'meal_6'=>implode(' , ' ,$meal6),

				  ]);
	



		    \Session::put('success','Meal updated.');
		     return redirect('meals');

			}



		}
		







		public function post_update_meals(Request $request)
		{


			$meal_plan_id=$request->id;

			$data=DB::table('meal_plan')->where('id',$meal_plan_id)->update([
			
				'meal_1'=>$request->meal_1,
				'meal_2'=>$request->meal_2,
				'meal_3'=>$request->meal_3,
				'meal_4'=>$request->meal_4,
				'meal_5'=>$request->meal_5,
				'meal_6'=>$request->meal_6,

			]);

			\Session::put('success','Meal Updated Successfuly');
			return back();


			
		}


		

		public function delete_meal($id)
		{

			DB::delete('delete from meal_plan where id=?',[$id]);

			\Session::put('success','Meal Deleted Successfully.');
			return back();


		}





		public function subscription()
		{

			$data=DB::table('plan_history')->join('tbl_users','plan_history.user_id','=','tbl_users.id')
			->join('plans','plan_history.plan_id','=','plans.id')
			->select('plan_history.user_id','tbl_users.name','plans.name as plan_name','tbl_users.email')
			->orderBy('plan_history.id','desc')->get();
		
			return view('admin.subscription.subscription',['data'=>$data]);
			
		}


		public function show_history($user_id)
		{
		
			$findid=DB::table('plan_history')->where('user_id',$user_id)->count();
			if($findid){


			
			
			$name=DB::table('plan_history')->join('tbl_users','plan_history.user_id','=','tbl_users.id')->
			where('plan_history.user_id',$user_id)
			->select('tbl_users.name')->get()->unique();



			$data=DB::table('plan_history')->join('tbl_users','plan_history.user_id','=','tbl_users.id')
			->join('plans','plan_history.plan_id','=','plans.id')->where('plan_history.user_id',$user_id)
			->select('plans.name as plan_name','plan_history.created_at','plan_history.isActive')->get()->unique('created_at');
			return view('admin.subscription.show',compact('name','data'));

		}
		else{

			\Session::put('failed','This user has not been choosen any plan');
			return back();
		}

		}


		public function request_for_meal()

		{

			$request_meal=DB::table('meal_request')->join('tbl_users','meal_request.user_id','=','tbl_users.id')
			->select('tbl_users.id','tbl_users.name','tbl_users.email','meal_request.requested_on')->orderBy('meal_request.id','desc')->get();

			return view('admin.meals.meal_request',['data'=>$request_meal]);

		}



		public function chat($id)
		{

			$chat=DB::table('chats')->where('from_user',$id)->leftJoin('tbl_users','chats.from_user','=','tbl_users.id')
			->orWhere('to_user',$id)->select('tbl_users.id','chats.from_user','tbl_users.name','chats.description','tbl_users.frontshot','chats.type','chats.color')->get();
			$user_id=$id;

			$name=DB::table('tbl_users')->where('id',$id)->get('name');

	

			if(count($chat)>=1){

				return view('admin.chat.chat',['chat'=>$chat,'user_id'=>$user_id,'name'=>$name]);

			}
			else{

	              $chat=DB::table('tbl_users')->where('id',$id)->select('id','name','current_shot')->get();

				  return view('admin.chat.chat',compact('chat','user_id'));


			}


		}


		public function get_chat(Request $request,$id)
		{

			$request->validate([

				'message'=>'required'

			]);


			DB::table('chats')->insert([

				'from_user'=>'admin',
				'to_user'=>$id,
				'description'=>$request->message,
                'type'=>'text'
			]);
			
			 // Send FCM notification
                $user = DB::table('tbl_users')->where('id', $id)->first(); // Assuming you are using authentication
                if ($user && $user->fcm_token) {
                    FCMService::send(
                        $user->fcm_token,
                        [
                            'title' => 'New Message Received',
                            'body' => "{$request->message}" // Including the message content in the notification body
                        ]
                    );
                }

		return back();


		}

public function notifications()
	{
		$data = DB::table('admin_notifications')->get();
		return view('admin.notification', compact('data'));
	}
		

	
	
}
