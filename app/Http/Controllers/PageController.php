<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Visitor;

class PageController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  String $slug
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug){

        $page = Page::where('slug', $slug)->first();

        if($page){ 

            $this->countVisit($request->ip(), $slug);

            return view('page', [
                'page' => $page
            ]); 

        }else{
            abort('404');
        }
    }

    /**
     * Process the page visit.
     *
     * @param  string $ip
     * @param  string $page
     * @return null
     */
    private function countVisit( $ip, $page ){

        //1 hour ago
        $timeLimit = date('Y-m-d H:i:s', strtotime('- 60 min'));

        $visitor = Visitor::where('ip', $ip)
             ->where('page', $page)
             ->where('access_date', '>' , $timeLimit)
             ->orderBy('access_date', 'desc')
             ->first();

         if(!$visitor){
             Visitor::create([
                 'ip' => $ip,
                 'page' => $page,
                 'access_date' => date('Y-m-d H:i:s')
             ]);
         }

    }
}
