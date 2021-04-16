<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;
use Illuminate\Support\Str;


class PageController extends Controller
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
        $pages = Page::paginate(10);

        return view('admin.pages.index', [
            'pages' => $pages
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
       return view('admin.pages.create');
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
        $data = $request->only('title', 'body');

        $validator = Validator::make( $data,[
            'title' => ['required','string', 'max:100'],
            'body' => ['nullable','string'],
            ]);

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $slug = Str::slug($data['title'], '-');

        $slugCount = Page::where('slug','like',$slug.'%')->count();

        if($slugCount > 0){
            $slug .= $slugCount;
        }
        $data['slug'] = $slug;

        $page = new Page;
        $page->title = $data['title'];
        $page->body = $data['body'];
        $page->slug = $data['slug'];
        $page->save();

        return redirect()->route('pages.index'); 
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
        $page = Page::find($id);
        
        if($page){
            return view('admin.pages.edit', ['page' => $page]);
        }
        return redirect()->route('pages.index');
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
        $data = $request->only('title', 'body');

        $page = Page::find($id);

        $validator = Validator::make( $data,[
            'title' => ['required','string', 'max:100'],
            'body' => ['nullable','string'],
            ]);
        
        
        if($validator->fails()){
            return back()
                ->withErrors($validator);
        }


        if($data['title'] !== $page->title ){

            $slug = Str::slug($data['title'], '-');
            $slugCount = Page::where('slug','like',$slug.'%')->count();

            if($slugCount > 0){
                $slug .= $slugCount;
            }

            $page->title = $data['title'];
            $page->slug = $slug;
        }

        $page->body = $data['body'];
        $page->save();

        return redirect()->route('pages.index'); 
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
        $page = Page::find($id);

        if($page){
            $page->delete();
        }
        return redirect()->route('pages.index');
    }
}
