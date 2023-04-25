<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\User;
use DateTime;
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
        return view('home');
    }

    public function feed()
    {
        $dtc1 = User::find(Auth::user()->id);
        $dtc2 = new DateTime($dtc1->created_at);
        $dtc3 = new DateTime();
        $dtc4 = $dtc2->diff($dtc3);

        $qc1 = count(Quiz::where('status', '=', 1)->get());
        $qc2 = count(Answer::where('user', '=', Auth::user()->id)->get());
        $qc3 = ($qc1 >= $qc2) ? false : true;

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
        return view('feed', compact('posts', 'members', 'likes', 'userLikes', 'comments', 'dtc4', 'qc3'));
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

    public function blockUser(Request $request)
    {
        $user = User::find($request->user_id);
        $user->state = 0;
        $user->save();

        return response()->json(['block' => true, 'user' => $request->user_id]);
    }
    public function unblockUser(Request $request)
    {
        $user = User::find($request->user_id);
        $user->state = 1;
        $user->save();

        return response()->json(['unblock' => true, 'user' => $request->user_id]);
    }
}
