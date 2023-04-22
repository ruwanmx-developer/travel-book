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
        $quizes = Quiz::where('status', '=', '1')->get();
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
        $def = false;
        $quizes = Quiz::all();
        return view('answers', compact('members', 'quizes', 'def'));
    }

    public function addQuiz(Request $request)
    {
        Quiz::create([
            'quiz' => $request->quiz,
            'status' => 1
        ]);

        $members = User::where('role', '!=', 'admin')->get();
        $res = User::find(Auth::user()->id);
        $def = false;
        $quizes = Quiz::all();
        return view('answers', compact('members', 'quizes', 'def'));
    }

    public function editQuiz(Request $request)
    {
        $quiz = Quiz::find($request->qid);
        $quiz->quiz = $request->quiz;
        $quiz->save();

        $members = User::where('role', '!=', 'admin')->get();
        $res = User::find(Auth::user()->id);
        $def = false;
        $quizes = Quiz::all();
        return view('answers', compact('members', 'quizes', 'def'));
    }
    public function deleteQuiz(Request $request)
    {
        $quiz = Quiz::find($request->id);
        if ($quiz) {
            $answers = Answer::where('quiz', '=', $quiz->id)->get();
            if (count($answers) == 0) {
                Quiz::where('id', '=', $quiz->id)->delete();
                return response()->json(['state' => true]);
            }
        }
        return response()->json(['state' => false]);
    }
    public function stateQuiz(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->status = $request->state;
        $quiz->save();

        $members = User::where('role', '!=', 'admin')->get();
        $res = User::find(Auth::user()->id);
        $def = false;
        $quizes = Quiz::all();
        return view('answers', compact('members', 'quizes', 'def'));
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
        $def = true;
        return view('answers', compact('quizes', 'answers', 'canEdit', 'members', 'def'));
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
