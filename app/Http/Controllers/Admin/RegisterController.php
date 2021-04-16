<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    /**
     * Render the register view
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.register');
    }

    /**
     * Handle the register action.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $data = $request->only(['name', 'email', 'password', 'password_confirmation']);


        $validator = Validator::make($data, [
                        'name' => "string|max:100|required|regex:/^[a-z ,.'-]+$/i",
                        'email' => 'required|email|max:100|unique:users|string',
                        'password' => 'required|min:3|max:13|confirmed|string'
                    ]);

        if($validator->fails()){
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                ]);

        Auth::login($user);

        return redirect()->route('admin');
    }
}
