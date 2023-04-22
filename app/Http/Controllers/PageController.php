<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $ip = '103.239.147.187'; //For static IP address get

        return view('home');
    }

    public function feed()
    {
        $posts = Post::with([
            'user' => function ($q) {
                $q->select('id', 'email', 'name', 'image');
            }
        ])->orderBy('created_at', 'desc')->paginate(7);
        $comments = Comment::with([
            'user' => function ($q) {
                $q->select('id', 'email', 'name', 'image');
            }
        ])->orderBy('id', 'DESC')->get();
        $likes = DB::table('like')->selectRaw("COUNT(*) as likes, post_id")->groupBy('post_id')->get();
        $userLikes = DB::table('like')->select("post_id")->where('user', '=', Auth::user()->id)->get();
        $members = User::where('role', '!=', 'admin')->get();
        return view('feed', compact('posts', 'members', 'likes', 'userLikes', 'comments'));
    }

    public function photo()
    {
        $photos = Post::with([
            'user' => function ($q) {
                $q->select('id', 'email', 'name');
            }
        ])->where('content_type', '=', 1)->orderBy('created_at', 'desc')->paginate(7);
        return view('photo')->with('photos', $photos);
    }

    public function video()
    {
        return view('video');
    }

    public function changeLike(Request $request)
    {
        if (Like::where('post_id', '=', $request->post_id)->where('user', '=', Auth::user()->id)->first() != null) {
            Like::where('post_id', '=', $request->post_id)->where('user', '=', Auth::user()->id)->delete();
        } else {
            Like::create([
                'post_id' => $request->post_id,
                'user' => Auth::user()->id
            ]);
        }
        $likes = DB::table('like')->where('post_id', '=', $request->post_id)->groupBy('post_id')->count();
        $isLiked = DB::table('like')->selectRaw("COUNT(*) as likes, post_id")->where('post_id', '=', $request->post_id)->where('user', '=', Auth::user()->id)->groupBy('post_id')->count();
        return response()->json(['count' => $likes, 'isLiked' => $isLiked]);
    }
}
