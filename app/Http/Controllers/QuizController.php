<?php

namespace App\Http\Controllers;

use App\Models\Team\Member;
use App\Quiz;
use App\Traits\GetSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class QuizController extends Controller
{
    use GetSubjects,SEOToolsTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:THteam'])->except([
            'index','show'
        ]);
        $this->authorizeResource(Quiz::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->isTeamMember()) {
            return view('quizzes.index')->with('quizzes', Quiz::orderBy('updated_at', 'desc')->paginate(config('app.pagination_max')));
        }
        return view('quizzes.index')->with('quizzes', Quiz::all_for_public());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::has('posts')->pluck('name', 'id');
        $subjects = $this->getSubjects();
        return view('quizzes.create')->with(compact('subjects'))->with(compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subjects = ($this->getSubjects())->keys();
        $v = Validator::make($request->all(),[
            'questions' => 'required|array|min:1',
            'subject' => ['required','string', Rule::in($subjects)],
            'description' => 'required|string',
            'total_mark' => 'required|numeric',
            'maker' => 'required|integer|exists:members,id',
            'revisor' => 'required|integer|exists:members,id',
        ]);
        if ($v->fails()) {
            return response()->json($v->errors());
        }
        $quiz = Quiz::create($request->all());
        $quiz->inserter()->associate(auth()->user()->member);
        if (auth()->user()->isAdmin()) {
            $quiz->maker()->associate($request->maker);
            $quiz->revisor()->associate($request->revisor);
        }
        $quiz->save();
        return response()->json([
            'success' => true,
            'message' => 'Quiz Saved Successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $questions = $quiz->questions;
        $questions = collect($questions)->shuffle()->transform(function($q) {
            $q['answers'] = collect($q['answers'])->shuffle()->toArray();
            return $q;
        })->toArray();
        $subject = $this->getSubjects()->get($quiz->subject);

        $this->seo()->setDescription($quiz->description);
        return view('quizzes.show')->with(compact('quiz'))->with(compact('subject'))->with(compact('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $members = Member::has('posts')->pluck('name', 'id');
        $subjects = $this->getSubjects();
        return view('quizzes.edit')->with(compact('quiz'))->with(compact('subjects'))->with(compact('members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $subjects = ($this->getSubjects())->keys();
        $v = Validator::make($request->all(), [
            'questions' => 'required|array|min:1',
            'subject' => ['required', 'string', Rule::in($subjects)],
            'description' => 'required|string',
            'total_mark' => 'required|numeric',
            'maker' => 'required|integer|exists:members,id',
            'revisor' => 'required|integer|exists:members,id',
        ]);
        if ($v->fails()) {
            return response()->json($v->errors());
        }
        $quiz->update($request->all());
        if (auth()->user()->isAdmin()) {
            $quiz->maker()->associate($request->maker);
            $quiz->revisor()->associate($request->revisor);
        }
        $quiz->save();
        return response()->json([
            'success' => true,
            'message' => 'Quiz Updated Successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz Deleted Successfully!');
    }

    public function revise_view(Request $request, Quiz $quiz)
    {
        //
    }

    public function revise(Request $request, Quiz $quiz)
    {
        //
    }
}
