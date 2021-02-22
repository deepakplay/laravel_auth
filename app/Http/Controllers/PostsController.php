<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Posts;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['posts'] = Posts::all();
        $data['posts'] = DB::table("posts")->select('posts.*', DB::raw('(SELECT name from users where users.id = posts.user_id) as name'))->orderBy('id', 'DESC')->paginate(6);
        return view('home', $data);
    }

    public function posts(){
        $user = Auth::user();
        $data['posts'] = Posts::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(4);
        $data['name'] = $user->name;
        return view('posts.index', $data);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {   
        if(isset($request->imgfile) && $request->file('imgfile')->getClientOriginalName()){
            $file= date('YmdHis').rand(1, 999999).'.'.$request->file('imgfile')->getClientOriginalExtension();
            $request->file('imgfile')->storeAs('public/images', $file);
        }else{
            $file='';
        }
        $post = new Posts();
        $post->postname = $request['name'];
        $post->description = $request['description'];
        $post->img = $file;
        $post->user_id = Auth::user()->id;
        $post->save();
        return Redirect::route('posts');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $post)
    {
        $user = Auth::user();
        if($user->id != $post->user_id){
            return Redirect::route('posts.index');
        }

        $data['posts'] = Posts::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(4);
        $data['name'] = $user->name;
        $data['post'] = $post;
        return view('posts.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Posts $post)
    {
        if(Auth::user()->id != $post->user_id){
            return Redirect::route('index');
        }

        if(isset($request->imgfile) && $request->file('imgfile')->getClientOriginalName()){
            Storage::delete('public/images/'.$post->img);
            $file= date('YmdHis').rand(1, 999999).'.'.$request->file('imgfile')->getClientOriginalExtension();
            $request->file('imgfile')->storeAs('public/images', $file);
            $post->img = $file;
        }

        $post->postname = $request['name'];
        $post->description = $request['description'];
        $post->save();
        return Redirect::route('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $post)
    {
        if(Auth::user()->id != $post->user_id){
            return Redirect::route('index');
        }

        Storage::delete('public/images/'.$post->img);
        $post->delete();
        return Redirect::route('posts');
    }
}
