<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{

    public function index()
    {
      $posts =  Post::with('user', 'tags')->get();

      return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required',
            'image' => 'required'
        ]);

//        $imgName = $_FILES['image']['name'];
//        $tmpName = $_FILES['image']['tmp_name'];
//        $imagesDirectory = 'images/';
//        $fullImagePath = $imagesDirectory . basename($imgName);
//
//
//
//        dd($tmpName);

//        move_uploaded_file($tmpName, $fullImagePath);

//        dd();
        $image = null;

        if ($request->hasFile('image')) {
            $path =  $request->file('image')->storeAs('images', $request->image->getClientOriginalName(), 'public');
            $image = '/storage/' . $path;
        }

        $post = Post::create([
                'title' => $request->title,
                'content' => $request->get('content'),
                'user_id' => $request->user_id,
                'image'  => $image,
                            ]);

        $newTags = explode(" ", $request->tags);

        foreach($newTags as $newTag) {
            $tagInDb = Tag::where('tag_name', '=', $newTag)->first();
            if ($tagInDb) {
                $post->tags()->attach($tagInDb->id);
            } else {
                $post->tags()->create([
                    'tag_name' => $newTag,
                    ]);
            }
        }

         return Post::with('tags')->orderby('id', 'desc')->first();
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
    }
}
