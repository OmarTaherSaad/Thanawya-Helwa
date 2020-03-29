<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MinistryExam extends Model
{
    protected $fillable = [
        'title', 'subject', 'link', 'year', 'educational_year' ];

    public function adder() {
        return $this->belongsTo('App\Models\Team\Member','added_by');
    }

    public function getSubjectNameAttribute()
    {
        return collect(json_decode(file_get_contents(storage_path('app/subjects.json'))))->get($this->subject);
    }

    public function getLinkToView()
    {
        return route('ministryExam.show', ['ministryExam' => $this]);
    }

    public function getLinkToEdit()
    {
        return route('ministryExam.edit', ['ministryExam' => $this]);
    }

    public function getLinkToUpdate()
    {
        return route('ministryExam.update', ['ministryExam' => $this]);
    }

    public function getLinkToDownload()
    {
        return route('ministryExam.download', ['ministryExam' => $this]);
    }

    public function getLinkToDelete()
    {
        return route('ministryExam.destroy', ['ministryExam' => $this]);
    }
}
