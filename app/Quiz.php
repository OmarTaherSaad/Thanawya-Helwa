<?php

namespace App;

use App\Models\Team\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'questions', 'subject', 'description', 'total_mark'
    ];

    protected $casts = [
        'questions' => 'array'
    ];

    public function maker() {
        return $this->belongsTo('App\Models\Team\Member','made_by');
    }
    public function revisor() {
        return $this->belongsTo('App\Models\Team\Member', 'revised_by');
    }
    public function inserter() {
        return $this->belongsTo('App\Models\Team\Member', 'inserted_by');
    }

    public function getIdentifierAttribute() {
        return $this->subject . $this->id;
    }
    public function getSubjectNameAttribute() {
        return collect(json_decode(file_get_contents(storage_path('app/subjects.json'))))->get($this->subject);
    }

    public static function all_for_member(Member $member = null,$type = null)
    {
        $quizzes = collect();
        if (isset($member)) {
            if ($type == null) {
                $quizzes = $member->quizzes_made->union($member->quizzes_inserted)->union($member->quizzes_revised);
            }
            else {
                $type = 'quizzes_'. $type;
                $quizzes = $member->$type;
            }
        }
        return $quizzes->orderBy('updated_at', 'desc')->paginate(config('app.pagination_max'));
    }
    public static function all_for_public()
    {
        $quizzes = Quiz::has('revisor');
        return $quizzes->orderBy('updated_at', 'desc')->paginate(config('app.pagination_max'));
    }

    public function getLinkToView()
    {
        return route('quiz.show', ['quiz' => $this]);
    }

    public function getLinkToEdit()
    {
        return route('quiz.edit', ['quiz' => $this]);
    }

    public function getLinkToUpdate()
    {
        return route('quiz.update', ['quiz' => $this]);
    }

    public function getLinkToRevise()
    {
        return route('quiz.revise', ['quiz' => $this]);
    }

    public function getLinkToDelete()
    {
        return route('quiz.destroy', ['quiz' => $this]);
    }

    public function getLinkToForceDelete()
    {
        return route('quiz.forceDelete', ['quiz' => $this]);
    }

    public function getLinkToRestore()
    {
        return route('quiz.restore', ['quiz' => $this]);
    }
}
