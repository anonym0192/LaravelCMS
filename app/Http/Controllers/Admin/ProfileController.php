<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $id = Auth::id();
        $user = User::find($id);

        if($user){
            return view('admin.profile.index', [
                'user' => $user
            ]);
        }else{
            return redirect()->route('admin');
        }  
    }

    public function save(Request $request)
    {
        //

        $loggedId = Auth::id();

        $user = User::find($loggedId);

        if($user){
            
            $data = $request->only(['email', 'name', 'password', 'password_confirmation']);

            $validator = Validator::make($data, [
                'name' => ['required','string', 'max:100', "regex:/^[a-z ,.'-]+$/i"],
                'email' => ['required','email', 'max:100'],
                'password' => ['nullable', 'string','min:3','max:13', 'confirmed']
            ]);

            if($validator->fails()){
                return back()->withErrors($validator);
            }

            $user->name = $data['name'];
            
            if($user['email'] != $data['email']){

                $emailExists = User::where('email', $data['email'])->get();
                
                if(count($emailExists) == 0){
                    $user->email = $data['email'];
                }else{
                    return back()->withErrors(['email' => 'This e-mail is already taken']);
                }
                
            }
            if($data['password']){
                $user->password = Hash::make($data['password']);
            }            

            $user->save();

            return redirect()
                ->route('profile')
                ->with('warning', 'The profile info was updated successfully!');
        
        }else{
            return redirect()->route('admin');
        }

        
        
    }
}
