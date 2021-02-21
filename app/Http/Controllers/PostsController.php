<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Posts;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data['posts'] = Posts::where('user_id', $user->id)->get();
        $data['name'] = $user->name;
        return view('welcome', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Posts();
        $post->name = $request['name'];
        $post->description = $request['description'];
        $post->user_id = Auth::user()->id;
        $post->save();
        return Redirect::route('index');
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
        $data['posts'] = Posts::where('user_id', $user->id)->get();
        $data['name'] = $user->name;
        $data['post'] = $post;
        return view('welcome', $data);
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
        $post->name = $request['name'];
        $post->description = $request['description'];
        $post->save();
        return Redirect::route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $post)
    {
        $post->delete();
        return Redirect::route('index');
    }
}
