<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
  public function add(NewsRequest $request)
  {
    $user = auth()->user()->load('role');
    if ($user->role->role != 'admin') {
      return response([
        'success' => false,
        'message' => 'Forbidden for you',
      ], 403);
    }
    $news = News::create(array_merge($request->validated(), ['user_id' => $user->id]));

    return response([
      'success' => true,
      'message' => 'success',
    ], 200);
  }
  public function publish($id)
  {
    $user = auth()->user()->load('role');
    $news = News::find($id);
    if ($news->user_id != $user->id) {
      return response([
        'success' => false,
        'message' => 'Forbidden for you',
      ], 403);
    }
    $news->status = 'published';
    $news->save();

    return response([
      'success' => true,
      'message' => 'success',
    ], 200);
  }
  public function get()
  {
    $news = News::with('user')
      ->get();
    return response([
      'success' => true,
      'message' => 'success',
      'news' => NewsResource::collection($news)
    ], 200);
  }
  public function unpublished()
  {
    $user = auth()->user()->load('role');
    $news = News::where('user_id', $user->id)
      ->where('status', 'unpublished')
      ->with('user')
      ->get();
    return response([
      'success' => true,
      'message' => 'success',
      'news' => NewsResource::collection($news)
    ], 200);
  }
}
