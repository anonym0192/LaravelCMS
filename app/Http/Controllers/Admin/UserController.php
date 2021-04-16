<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    function __construct(){

        $this->middleware('auth');
        $this->middleware('can:edit_users');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::paginate(5);

        $loggedId = Auth::user()->id;

        return view('admin.user.index', [
            'users' => $users,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.create');
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

        $data = $request->only('name', 'email', 'password', 'password_confirmation');

        $validator = Validator::make( $data,[
            'name' => ['required','string', 'max:100', "regex:/^[a-z ,.'-]+$/i"],
            'email' => ['required','email', 'max:100', "unique:users"],
            'password' => ['required','string','min:3','max:13', 'confirmed']
            ]);
        
        
        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create(['name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'])
                    ]);

        return redirect()->route('users.index');
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

        $user = User::find($id);

        if($user){
            return view('admin.user.edit', ['user' => $user]);
        }

        return redirect()->route('users.index');
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
        $user = User::find($id);

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
        }

        return redirect()->route('users.index');
        
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
        $loggedId = Auth::user()->id;


        if($loggedId != $id){
            $user = User::find($id);
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
