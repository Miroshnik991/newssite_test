<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class UserController extends Controller
{
    public function show($id)
    {
      $user = User::find($id);
      $posts = $user->posts;
      $posts->load(['tags'=> function($query) {
        $query->select('tag_name', 'tag_id as id');
      }]);
      return response()->json($user);
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'name' => 'required',
        'avatar' => 'nullable',
    ]);

    $user = User::find($id);

    $userData = [
      'name' => $request->name,
    ];
    
    if ($request->hasFile('avatar')) { 
      $path =  $request->file('avatar')->storeAs('avatars', $request->avatar->getClientOriginalName(), 'public');
      $userData['avatar'] = '/storage/' . $path;
    } 

    $user->update($userData);

      return $user;
    }
  }
