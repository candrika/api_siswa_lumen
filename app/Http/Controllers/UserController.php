<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Mail\ResetPasswordMail;

class UserController extends Controller{

	public function index(){

		$users =DB::table('user')->get();

		return response()->json(['status'=>true,'data'=>$users]);
	}

	public function login(Request $request){
		
		$this->validate($request,[
			'email'=>'required|email',
			'password'=>'required'
		]);

		$user = DB::table('user')
				->where('username',$request->email)
				->where('password',$request->password);

		if($user->count() > 0){
			$rows = $user->first();
			if($rows->api_token ==null){
				$api_token_update = ['api_token'=>Hash::make($request->password)];
				DB::table('user')->where('username',$request->email)
				->where('password',$request->password)->update($api_token_update);
			}
			// print_r($rows);
			return response()->json(['status'=>true,'message'=>'User berhasil login','data'=>$rows]);
		}else{
			return response()->json(['status'=>false,'message'=>'User tidak dapat ditemukan']);
		}		
	}

	public function register(Request $request){

		$this->validate($request,[
			'username'=>'required',
			'password'=>'required',
			'user_group'=>'required',
		]);

		$data = [
			'username'=>$request->input('username'),
			'password'=>$request->input('password'),
			'id_user_group'=>$request->input('user_group'),
			'updated_at'=>null,
			'created_at'=>date('Y-m-d'),
			'api_token'=>app('hash')->make($request->input('password'))
		];

		DB::table('user')->insert($data);

		return response()->json(['status'=>true,'message'=>'insert successfuly']);
	}

	public function editUser($id){

		if($id==null){
			return response()->json(['status'=>true,'message'=>'user id tidak boleh kosong']);
		}

		$user =DB::table('user')->where('user_id',$id)->get();

		return response()->json(['status'=>true,'data'=>$user]);
	}

	public function updateUser(Request $request,$id){


		$this->validate($request,[
			'username'=>'required',
			'password'=>'required',
			'user_group'=>'required',
		]);

		$data = [
			'username'=>$request->username,
			'password'=>$request->password,
			'id_user_group'=>$request->user_group
		];

		DB::table('user')->where('user_id',$id)->update($data);

		return response()->json(['status'=>true,'message'=>'update successfuly']);
	}

	public function deleteUser($id){
		DB::table('user')->where('user_id',$id)->delete();

		return response()->json(['status'=>true,'message'=>'delete successfuly']);
	}

	// public function sendResetMail(Request $request){

	// 	$this->validate($request,[
	// 		'email'=>'required|'
	// 	]);
		
	// 	$user=DB::table('user')->where('username',$request->email)->first();

	// 	DB::table('user')->where('username',$request->email)->update(['reset_token'=>Str::random(40)]);

	// 	Mail::to($user->username)->send(new ResetPasswordMail($user));;

	// 	return  response()->json(['status'=>'success','data'=>$user->reset_token]);
	// }

	public function verifyResetPassword(Request $request,$token){

		$this->validate($request,[
			'password'=>'required|string|min6'
		]);

		$user = DB::table('user')->where('reset_token',$token)->first();

		if($user){
			DB::table('user')->where->where('reset_token',$token)->update(['api_token'=>Hash::make($request->password)]);
		}
	}
}
