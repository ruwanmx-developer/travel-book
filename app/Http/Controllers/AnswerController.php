<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AnswerController extends Controller
{
    public function quiz()
    {
        $answers = Answer::where('user', '=', Auth::user()->id)->get();
        $quizes = Quiz::all();
        $res = User::find(Auth::user()->id);
        $datetime1 = new DateTime($res->created_at);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);
        $canEdit = ($interval->days <= 15) ? true : false;
        return view('quiz', compact('quizes', 'answers', 'canEdit'));
    }
    public function answers()
    {

        $members = User::where('role', '!=', 'admin')->get();
        $res = User::find(Auth::user()->id);
        $quizes = false;
        return view('answers', compact('members', 'quizes'));
    }
    public function answer(int $id)
    {
        $answers = Answer::where('user', '=', $id)->get();
        $quizes = Quiz::all();
        $members = User::where('role', '!=', 'admin')->get();
        $res = User::find(Auth::user()->id);
        $datetime1 = new DateTime($res->created_at);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);
        $canEdit = ($interval->days <= 15) ? true : false;
        return view('answers', compact('quizes', 'answers', 'canEdit', 'members'));
    }

    public function saveAnswer(Request $request)
    {

        $pre = Answer::where('quiz', '=', $request->quiz)->where('user', '=', Auth::user()->id)->first();
        if ($pre != null) {

            if ($pre->answer_type == 2) {
                File::delete('answer_contents/' . $pre->answer);
                if ($request->answer_type == 2) {
                    $file = $request->file('answer');
                    $filename = Auth::user()->id . "_" . Carbon::now() . "." . $file->getClientOriginalExtension();
                    $filename = str_replace(':', '_', $filename);
                    $filename = str_replace(' ', '_', $filename);
                    $destinationPath = 'answer_contents/';
                    $file->move($destinationPath, $filename);

                    $pre->answer = $filename;
                    $pre->save();

                    return response()->json(['message' => 'Answer updated']);
                } else {
                    $pre->answer = $request->answer;
                    $pre->answer_type = $request->answer_type;
                    $pre->save();
                    return redirect()->to('quiz');
                }
            } else {
                if ($request->answer_type == 2) {
                    $file = $request->file('answer');
                    $filename = Auth::user()->id . "_" . Carbon::now() . "." . $file->getClientOriginalExtension();
                    $filename = str_replace(':', '_', $filename);
                    $filename = str_replace(' ', '_', $filename);
                    $destinationPath = 'answer_contents/';
                    $file->move($destinationPath, $filename);

                    $pre->answer = $filename;
                    $pre->answer_type = 2;
                    $pre->save();

                    return response()->json(['message' => 'Answer updated']);
                } else {
                    $pre->answer = $request->answer;
                    $pre->save();
                    return redirect()->to('quiz');
                }
            }
        } else {
            if ($request->answer_type == 2) {
                $file = $request->file('answer');
                $filename = Auth::user()->id . "_" . Carbon::now() . "." . $file->getClientOriginalExtension();
                $filename = str_replace(':', '_', $filename);
                $filename = str_replace(' ', '_', $filename);
                $destinationPath = 'answer_contents/';
                $file->move($destinationPath, $filename);

                Answer::Create([
                    'quiz' => $request->quiz,
                    'answer' => $filename,
                    'answer_type' => $request->answer_type,
                    'user' => Auth::user()->id
                ]);

                return response()->json(['message' => 'Answer added']);
            } else {
                Answer::Create([
                    'quiz' => $request->quiz,
                    'answer' => $request->answer,
                    'answer_type' => $request->answer_type,
                    'user' => Auth::user()->id
                ]);
                return redirect()->to('quiz');
            }
        }

        return redirect()->to('quiz');
    }
}
