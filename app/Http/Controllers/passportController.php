<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\passport;
use App\Models\admin;

use Illuminate\Support\Facades\Validator;  // for validation add this 
use Illuminate\Support\Facades\Hash;

class passportController extends Controller
{
	// fetch api get method 
	
	public function allshow()
    {
       $data=passport::all();
	   return response()->json([
	   'status'=>200,
	   'passports'=>$data
	   ]);
    }
	
	public function single_show($id)
    {
         $data=passport::find($id);
		 return response()->json([
		 'status'=>200,
		 'passports'=>$data
		 ]);
    }
	
	function search($key) 	
    {
         $data=passport::where('name','LIKE',"%$key%")->orWhere('email','LIKE','%'.$key.'%')->get();
		 return response()->json([
		 'status'=>200,
		 'passports'=>$data
		 ]);
    }
	
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name'=>'Required',
            'email'=>'Required|email',
            'password'=>'Required',
			'c_password'=>'Required'
        ]);
		
		if($validate->fails())
		{
			return [
				'success' => 0, 
				'message' => $validate->messages(),
			];
		}
		else
		{
			$data=new passport;
			$data->name=$request->name;
			$data->email=$request->email;
			$data->password=Hash::make($request->password);	
			$data->c_password=Hash::make($request->c_password);
			
			//create tocken 
			//$token=$data->createToken($data->email.'_Token')->plainTextToken;
			//$token=$data->token=Hash::make($request->email);
			
			$data->save();
			return response()->json([
			'status'=>200,
			
			'message'=>"Register Success"
			]);
			//return 	passport::create($request->all());
		}
    }

    /**
     * Display the specified resource.
     */
    public function show(passport $passport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(passport $passport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
			$data=passport::find($id);
			$data->name=$request->name;
			$data->email=$request->email;
			//$data->password=Hash::make($request->password);
			//$data->c_password=Hash::make($request->c_password);
			$data->update();
			return response()->json([
			'status'=>200,
			'message'=>"Update Success"
			]);
		
    }
	
	public function updatestatus(Request $request,$id)
    {
        $data=passport::find($id);
		$status=$data->status;
		if($status === "Block")
		{	
			$data->status="Unblock";
			$data->save();
			return response()->json([
			'status'=>200,
			'msg'=>"Unblock Success"
			]);
		}
		else
		{
			$data->status="Block";
			$data->save();
			return response()->json([
			'status'=>200,
			'msg'=>"Block Success"
			]);
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        passport::find($id)->delete();
		return response()->json([
		'status'=>200,
		'msg'=>"Delete Success"
		]);
    }
	
	public function passport_login(Request $request)
	{
		$validate=Validator::make($request->all(),[
            'email'=>'Required|email',
            'password'=>'Required'
        ]);
		
		if($validate->fails())
		{
			return [
				'success' => 0, 
				'message' => $validate->messages(),
			];
		}
		else
		{
			//$passport=passport::where('email',$request->email)->first();
			$passport=passport::where('email' , '=' , $request->email)->first();	
			if(! $passport || ! Hash::check($request->password,$passport->password))
			{
				return response()->json([
					'status'=>201,
					'msg'=>"Passport Login Failed due to Wrong Creadantial"
					]);
			}
			else
			{
				
				if($passport->status=="Unblock")
				{
					return response()->json([
					'status'=>200,
					'msg'=>"Passport Login Success",
					//'name'=>$passport->name,
					//'token'=>$passport->token
					]);
				}
				else
				{
					return response()->json([
					'status'=>201,
					'msg'=>"Passport Blocked so Login Failed"
					]);
				}	
			}
		}
	
	}
}
