<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Article;
use App\Models\User;
use App\Models\Post;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return home view
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data  = request()->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,fig,svg,',
            'description' => 'required',
            'location' => 'required',
            'tags' => 'required',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $imagePath = $destinationPath. "/". $name;
            Image::make($image)->resize(800, 400)->save($imagePath);
            $data['image'] = $name;
        }

        auth()->user()->posts()->create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data  = request()->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,fig,svg,',
            'description' => 'required',
            'location' => 'required',
            'tags' => 'required',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $imagePath = $destinationPath. "/". $name;
            Image::make($image)->resize(800, 400)->save($imagePath);
            $data['image'] = $name;
        }

        $post->fill($data)->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/'.$post->user->username)->with('success', 'Post deleted successfully');

    }
}
