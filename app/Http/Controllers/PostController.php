<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $dtc1 = User::find(Auth::user()->id);
        $dtc2 = new DateTime($dtc1->created_at);
        $dtc3 = new DateTime();
        $dtc4 = $dtc2->diff($dtc3);

        $qc1 = count(Quiz::where('status', '=', 1)->get());
        $qc2 = count(Answer::where('user', '=', Auth::user()->id)->get());
        $qc3 = ($qc1 >= $qc2) ? false : true;


        $postCount = count(Post::where('uploaded_by', '=', Auth::user()->id)->get());

        $quizCount = count(Quiz::where('status', '=', 1)->get());

        $answerCount = count(Answer::where('user', '=', Auth::user()->id)->get());
        $state = true;
        if ($postCount >= 2 and  $quizCount > $answerCount) {
            $state = false;
        }
        return view('new-post')->with('state', $state)->with('dtc4', $dtc4)->with('qc3', $qc3);
    }
    public function savePost(Request $request)
    {
        $request->validate([
            'description' => 'required|max:500',
            'content' => 'required|mimes:png,jpeg,mp4,gif'
        ]);
        $file = $request->file('content');
        $filename = Auth::user()->id . "_" . Carbon::now() . "." . $file->getClientOriginalExtension();
        $filename = str_replace(':', '_', $filename);
        $filename = str_replace(' ', '_', $filename);
        $destinationPath = 'post_contents/';
        $file->move($destinationPath, $filename);
        $filetype = 0;
        if (strstr($filename, ".mp4")) {
            $filetype = 2;
        } else {
            $filetype = 1;
        }
        Post::Create([
            'description' => $request->description,
            'content_url' => $filename,
            'content_type' => $filetype,
            'uploaded_by' => Auth::user()->id,
            'lat' => $request->lat,
            'log' => $request->log,
        ]);

        return redirect()->route('feed');
    }
    public function deletePost(Request $request)
    {
        $post = Post::find($request->post_id);
        File::delete('post_contents/' . $post->content_url);
        Post::where('id', '=', $request->post_id)->delete();
        Like::where('post_id', '=', $request->post_id)->delete();
        Comment::where('post', '=', $request->post_id)->delete();
        return response()->json(['deleted' => true]);
    }
    public function blockPost(Request $request)
    {
        $post = Post::find($request->post);
        $post->block = $request->content;
        $post->save();

        return response()->json(['block' => true, 'id' => $request->post, 'reason' => $request->content]);
    }
    public function unblockPost(Request $request)
    {
        $post = Post::find($request->post);
        $post->block = "";
        $post->save();

        return response()->json(['unblock' => true]);
    }
    public function saveComment(Request $request)
    {
        $request->validate([
            'content' => 'required|max:500',
            'post' => 'required'
        ]);
        Comment::Create([
            'content' => $request->content,
            'post' => $request->post,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['add' => true, 'image' => Auth::user()->image, 'name' => Auth::user()->name, 'cmt' => $request->content]);
    }
}
