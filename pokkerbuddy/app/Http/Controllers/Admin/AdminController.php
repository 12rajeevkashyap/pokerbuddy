<?php
namespace App\Http\Controllers\Admin;
use App\AdvertisementCount;
use App\Http\Controllers\Controller;
use App\RestaurantList;
use App\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Mail;
use Redirect;
use Session;
use View;
use Crypt;
use App\Advertisement;
use Excel;

use App\Doctor;
use Illuminate\Support\Facades\Artisan;
class AdminController extends Controller
{
    public function index(Request $request)
    {
    }
    
    public function adupload()
    {
      
      return view('admins.ad_genre');
    }
    
//   public function export(Request $request)
//     {
      
//       //echo"Hello";
//       return view('admins.export');
//     }
    
  public function export(Request $request)
    {
      return view('admins.rajeev');  
    }
  
  public function uploadTopic(Request $request)
    {
        $input = $request->all();
        
        Topic::create($input);
        
        return redirect('admin/genre_list');
    }
    public function login(Request $request)
    {
        if ((Auth::user())) {
            return redirect()->intended(route('admins.user_list'));
        } else {
            if ($request->isMethod('post')) {
                $rule = $this->validate($request, [
                    'email'    => 'required|email|max:190',
                    'password' => 'required|max:190',
                ]);

                 // dd($rule);

                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => '1'], $request->remember)) {


                    return redirect('admin/user_list');
                } 
                else {
                $request->session()->flash('alert-danger', 'Wrong Credentials ');
                return redirect('/admin/login');
                }
            }
            return view('admins.login');
        }
    }
 public function privacy(Request $request)
 {
  
    return view('admins.privacy');
 }
    public function changeStatus($id)
    {
        $user = User::find($id);
        if($user->admin_status == "0"){
            $user->admin_status = "1";
        } else {
            $user->admin_status = "0";
        }
        $user->save();
        return back();
    }
    public function changeStatusad($id)
    {
        $ad = Advertisement::find($id);
        if($ad->status == "0"){
            $ad->status = "1";
        } else {
            $ad->status = "0";
        }
        $ad->save();
        return back();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }
    public function user_list(Request $request)
    {
        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            $users = User::where('is_admin', '0')->orderBy('id', 'DESC')->get();
            foreach ($users as $user) {
                if(empty($user->image)){
                $user->image = url('/public/img/user-default.png');
                }
                $user->created_on = date("dFY", strtotime($user->created_at));
            }
            return view('admins.user_list', compact('users'));
        }
    }
 public function help(Request $request)
    {
        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } 
        else {
            $obj   = new CommonAdminController;
            $users=DB::select('select users.id , helps.id as help_id,users.first_name,users.last_name,users.email,helps.message from helps inner join users on helps.user_id=users.id');
            foreach ($users as $user) {
                if(empty($user->image)){
                $user->image = url('/public/img/user-default.png');
                }  
              }
            return view('admins.help', compact('users'));
        }
    }
    
    public function ad_list(Request $request)
    {
        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            $users =  DB::table('screen_adds')->select('*')->orderBy('id', 'DESC')->get();
            foreach ($users as $user) {
                if(empty($user->image)){
                $user->image = url('/public/img/user-default.png');
                }
                $user->created_on = date("dFY", strtotime($user->created_at));
            }  
            return view('admins.ad_list', compact('users'));
        }       
    }

   public function host_rating(Request $request)
    {

        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            $users =  DB::select('select users.id,host_rates.id,users.first_name,users.last_name,host_rates.host_id,host_rates.rate,host_rates.review_msg from users inner join host_rates on users.id=host_rates.host_id');

            foreach ($users as $user) {             
            }
            return view('admins.host_rating', compact('users'));
        }       
    }

     public function report_list(Request $request)
    {
        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            $users =  DB::table('report_users')->select('*')->orderBy('id', 'DESC')->get();

            $users=DB::select("select users.name,users.last_name,report_users.created_at,report_users.reported_to,report_users.reason,users.id ,report_users.user_id,report_users.id as re_id ,users.gender from report_users inner join users on users.id=report_users.user_id");
             return view('admins.report_list', compact('users'));
        }
       
    }

     public function delete_report(Request $request)
    {
    $id=$_POST['id'];    
    $dd=DB::delete('delete from report_users where id = ?',[$id]);

    }
     public function show_report(Request $request)
    {
    $id=$_POST['id'];    
    //$dd1=DB::select('select * from users where id = ?',[$id]);
        $dd1= DB::select('select * from users  inner join report_users on report_users.reported_to=users.id');
   $data1=array();
   $count=count($dd1);

   //print_r($dd1);
   foreach($dd1 as$userData)
   {
  if($count > 0){
        $data['status'] = 'ok';
        $data['result'][] = $userData;
    }
    else{
        $data['status'] = 'err';
        $data['result'] = '';
    }
    }
    echo json_encode($data);
    }

  
  public function rating_delete(Request $request){
    $delete_id=$_POST['delete_id'];
    DB::delete("delete from host_rates where id='$delete_id'");
    }

 function newsletter(Request $request)
 {
   if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            //$users =  DB::table('screen_adds')->select('*')->orderBy('id', 'DESC')->get();
            $users=DB::select('select * from  newletter where status="1"');
             
            foreach ($users as $user) {
                if(empty($user->image)){
                $user->image = url('/public/img/user-default.png');
                }
                $user->created_on = date("dFY", strtotime($user->created_by));
            }

            return view('admins.newsletter', compact('users'));
        }
 } 

 public function delete_newletter(Request $request)
 {
  $id=$_POST['id'];    
  DB::delete('delete from newletter where id = ?',[$id]);
 }


 function contact(Request $request)
 {

   if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $obj   = new CommonAdminController;
            //$users =  DB::table('screen_adds')->select('*')->orderBy('id', 'DESC')->get();
            $users=DB::select('select * from  contacts where status="Active"');
             
            foreach ($users as $user) {
                if(empty($user->image)){
                $user->image = url('/public/img/user-default.png');
                }
                $user->created_on = date("dFY", strtotime($user->created_at));
            }

            return view('admins.contact', compact('users'));
        }
 } 

 public function delete_contact(Request $request)
 {

   $id=$_POST['id'];    
  DB::delete('delete from contacts where id = ?',[$id]);
 }


  function add_screen_add(Request $request)
  {
    error_reporting(0);
    if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else { 
      return view('admins.add_screen');  
        }  
        }

    public function inert_ad(Request $request){
    $user_id=10;  
 if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else { 
       $hidden_id=$request->input('hidden_id');
       $hidden_image=$request->input('hidden_image');
    if(empty($hidden_image))
    {
        $this->validate($request,[       
         'image'=>'mimes:jpeg,jpg,png,gif|required|max:10000'
      ]); 
    }
    
     if($request->hasFile('image')) 
          {
            $image = $request->file('image');
            $name = md5($user_id.time()).rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/adds');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
           }

       error_reporting(0);
       if(!empty($hidden_image) and empty($image) and !empty($hidden_id)){
     $data=array('image'=>$hidden_image,'status'=>'InActive','created_at'=>now(),'updated_at'=>now());
      DB::table('screen_adds')->where('id',$hidden_id)->update($data);
        Session::flash('message', 'Data updated successfully');    
       
       }
       
    if(!empty($hidden_image) and !empty($image) and !empty($hidden_id)){
   $data=array('image'=>$name,'status'=>'InActive','created_at'=>now(),'updated_at'=>now());
        DB::table('screen_adds')->where('id',$hidden_id)->update($data);
       Session::flash('message', 'Data updated successfully'); 
       }
     if(empty($hidden_id))
     {
      $data=array('image'=>$name,'status'=>'InActive','created_at'=>now(),'updated_at'=>now());
       DB::table('screen_adds')->insert($data);
         Session::flash('message', 'Data add successfully');   
     }
      return redirect('admin/ad_list');
        } 
    }  
  public function delete_ad(Request $request)
  {
    $id=$_POST['id'];
    DB::table('screen_adds')->where('id',$id)->delete();
  }

    public function edit_data(Request $request,$id)
    {
 if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else { 
  $user = DB::table('screen_adds')->where('id', $id)->first();
      //$user='rajeev';
      return view('admins.add_screen',compact('user'));
        }
    }  
  
   public function fetch_status(Request $request)
   {
           $id=$_POST['id'];
           $ad_value=$_POST['ad_value'];
           $status=$_POST['status'];
          
           
        if($ad_value=='user') {
         DB::update('update users set status = ? where id = ?',[$status,$id]);   
        }

        if($ad_value=='help') {
         DB::update('update helps set status = ? where id = ?',[$status,$id]);   
        }
        
        else{
         DB::update('update screen_adds set status = ? where id = ?',[$status,$id]);
        }
        
   }

   public function delete_help(Request $request){

        $id=$_POST['id'];
        DB::delete("delete from helps where id='$id'"); 
   }


  
    public function common_delete($id,$table)
    {
       
            DB::table($table)->where('id', $id)->delete();
            return back();
           
    }
    
public function profile(Request $request)
    {
         $user_id=10;
       // error_reporting(0);   
        if (is_null(Auth::user())) {
            return redirect()->intended(route('admins.login'));
        } else {
            $admin = User::where("is_admin", "1")->first();
            if ($request->isMethod('post')) {
                $rule = $this->validate($request, [
                    'email'    => 'required|email|max:190',
                    //'password' => 'required|max:190',
                    'name'     => 'required|max:190',
                    'image'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                ]);
              

        if($request->hasFile('image')) 
          {
            $image = $request->file('image');
            $name = md5($user_id.time()).rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/view_profile');

            $imagePath = $destinationPath. "/".  $name;
            
            $image->move($destinationPath, $name);
          
          

           }

            $hidden_image=$request->input('hidden_image');
             if(!empty($hidden_image) and empty($name))
             {
             $update = array(
                    'email'       => $request->email,
                    'name'        => $request->name,
                    'image'        =>$hidden_image,
                );
           if (User::where('id', $admin->id)->update($update)) {
                    $request->session()->flash('success', 'Profile update successfully!');
                    Session::flash('message', 'Profile updated successfully'); 
                  //Session::flash('alert-class', 'alert-danger'); 
                    return redirect('/admin/profile');
                } else {
               Session::flash('message', 'Profile updated successfully');
                }


             }
        else
            {

               $update1 = array(
                    'email'       => $request->email,
                    'name'        => $request->name,
                    'image'        =>$name,
                );
              
              

             
                if (User::where('id', $admin->id)->update($update1)) {
                    $request->session()->flash('success', 'Profile update successfully!');
                    return redirect('/admin/profile');
                } else {
                $request->session()->flash('alert-danger', 'Internal error .');
                }
             }
                
       
                if (User::where('id', $admin->id)->update($update)) {
                    $request->session()->flash('success', 'Profile update successfully!');
                    return redirect('/admin/profile');
                } else {
                $request->session()->flash('alert-danger', 'Internal error .');
                }
            } 
            else {
                return view('admins.profile', compact('admin'));
            }
        }
    }
    
    public function forgot_password(Request $request)
    {
        try {
            if (Auth::user()) {
                return redirect()->intended(route('admins.user_list'));
            } elseif ($request->isMethod('post')) {
                $this->validate($request, [
                    'email' => 'required|email',
                ]);
            $create = User::where('is_admin', '1')->where('email', $request->email)->first();
                if (!empty($create)) {
                    $password                = $create->confirm_password; //mt_rand(10000, 99999);
                    $create->password        = Hash::make($password);
                    $create->confirm_password = $password;
                    if ($create->save()) {
                        $email   = $create->email;
                        $subject = "New Password";
                        
                        $message="send message";
if (!empty($email)) 
{
   Mail::send('emails.forgotPassword', ['password' => $password,'email' => $create->email], function ($message) use ($email, $subject) {
                            $message->to($email)->subject($subject);
                        });
    $request->session()->flash('alert-success', 'Password send to your mail');
    return redirect('/admin/login');
    }
                         else {
                            $request->session()->flash('alert-danger', 'Fail to send.');
                            return redirect('/admin/forgot_password');
                        }
                    } else {
                        $request->session()->flash('alert-success', 'Internal Server Error');
                    }
                } else {
                    $request->session()->flash('alert-danger', 'Not a valid user.');
                }
                return Redirect::back();
            } else {
                return view('admins.forgot_password');
            }
        } catch (Exception $e) {
        }
    }
    public function change_user_status(Request $request){
        $id = Crypt::decrypt($request->id);
    }
     
}