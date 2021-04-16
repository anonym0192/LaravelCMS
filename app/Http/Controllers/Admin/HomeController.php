<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Visitor;
use App\Models\User;

class HomeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function index(Request $request){

        $allowedDays = [7,30,60,90];

        $filter = $request->input('datefilter');

        //Check the number of days input, if is not an allowed value then a default value is used
        if( !in_array( intval($filter), $allowedDays) ){
            $filter = 30;
        }
        
        $visitsCount = 0;
        $userCount = 0;
        $pageCount = 0;
        $onlineCount = 0;

        
        $filterDate = date('Y-m-d H:i:s', strtotime('- '.$filter.' days'));

        $visitsCount = Visitor::where('access_date', '>=', $filterDate)->count();

        $pageCount = Page::count();
        $userCount = User::count();

        $datelimit = date('Y-m-d H:i:s', strtotime('- 5 minutes'));
        $visitorsList = Visitor::select('ip')->where('access_date', '>=', $datelimit)->groupBy('ip')->get();

        $onlineCount = $visitorsList->count();

        $pageData = [];

        $allPages = Visitor::selectRaw('page as name, count(page) as visits')
            ->where('access_date', '>=', $filterDate)
            ->groupBy('page')->get();

        $chartColors = [];

        //Generate an array that contain the data for the chart  
        foreach($allPages as $page){
            $pageData[$page['name']] = $page['visits'];
            $chartColors[] = $this->random_color(); 
        }

        //Generate the labels for the chart in json format
        $chartLabels = json_encode(array_keys($pageData));

        //Generate the values for the chart in json format 
        $chartValues = json_encode(array_values($pageData));

        //Pass random colors for the chart in json format
        $chartColors = json_encode($chartColors);

        return view('admin.home', [
            'visitsCount' => $visitsCount,
            'userCount' => $userCount,
            'pageCount' => $pageCount,
            'onlineCount' => $onlineCount,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'chartColors' => $chartColors,
            'dateFilter' => $filter
        ]);  
    }

    private function random_color($start = 0x000000, $end = 0xFFFFFF) {
        return sprintf('#%06x', mt_rand($start, $end));
     }
}
