<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{

    function __construct(){

        $this->middleware('auth');
    }
    //
    /**
     * Render the Setting view
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $settings = [];

        $settingsDB = Setting::all();
        
        foreach($settingsDB as $setting){

            $key = $setting['name'];
            $settings[$key] = $setting['value'];
        }

        return view('admin.settings.index', ['settings' => $settings]);
    }

    /**
     * Save the Setting 
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){

        $data = $request->only(['title', 'subtitle', 'bgColor','txtColor']);

        
        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'bgColor' => ['string', 'regex:/^#[A-Fa-f0-9]{6}$/i'],
            'txtColor' => ['string', 'regex:/^#[A-Fa-f0-9]{6}$/i']
        ]);

        echo $data['bgColor'];

        if($validator->fails()){

            return back()
                ->withErrors($validator);
        }


        foreach($data as $key => $value){
            Setting::where('name', $key)->update(['value' => $value]);
        }

        return redirect()
            ->route('settings')
            ->with('warning', 'The setting was updated successfully!');    
    }

}