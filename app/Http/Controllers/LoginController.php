<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    } 

     public function register()
    {
        return view('auth.registeration');
    }  

     public function registerUser(Request $request)
     {
       $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:12',
        ]);
       $user = new User;
       $user ->name =$request->name;
       $user ->email =$request->email;
       $user ->password = Hash::make($request->password);
       $res=$user->save();
       if( $res){
        return back()->with('success','You have successfully registered');
    }
    else{
         return back()->with('fail');
    }

     }

     
     public function loginformUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);
        $user_data =  array(
           'email'=> $request->get('email'),
           'password'=> $request->get('password'),

        );
        if(Auth::attempt($user_data))
        {
            return back()->with ('error','wrong login details');
              
        }
        else{

           return redirect('home'); 
        }
        }
        public function dashboard()
    {
        $user::auth_user();
        $data=array();
        if(Session::has('loginid')){
            $data=User::where('id','=',Session get('loginid'))->first();
        }
        return view('dashboard',compact('data'));

        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

     public function logOut(){
        if(Session::has('login')){
            Session::pull('login');
            return redirect('loginUser');
        }
     } 
    
} 

