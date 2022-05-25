<?php

namespace App\Models\Team;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends User implements HasMedia
{
    use InteractsWithMedia;


    protected $fillable = ['title_on_team', 'title_personal', 'text', 'name', 'status'];

    protected $casts = [
        'status' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Team\Post', 'written_by');
    }
    public function coposts()
    {
        return $this->hasMany('App\Models\Team\Post', 'cowriter_id');
    }
    public function quizzes_made()
    {
        return $this->hasMany('App\Quiz', 'made_by');
    }
    public function quizzes_revised()
    {
        return $this->hasMany('App\Quiz', 'revised_by');
    }
    public function quizzes_inserted()
    {
        return $this->hasMany('App\Quiz', 'inserted_by');
    }

    public function getLinkToView()
    {
        return route('members.show', ['member' => $this->id]);
    }

    public function getLinkToEdit()
    {
        return route('members.edit', ['member' => $this->id]);
    }

    public function getLinkToUpdate()
    {
        return route('members.update', ['member' => $this->id]);
    }
    public function getLinkToDelete()
    {
        return route('members.destroy', ['member' => $this->id]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('members/profile-photos')
            ->useFallbackUrl(asset('storage/members/profile-photos/default.jpg'))
            ->useFallbackPath(asset('storage/members/profile-photos/default.jpg'))
            ->singleFile();
    }

    public function getStatusCsvAttribute()
    {
        $str = '';
        foreach ($this->status as $s) {
            $str .= ',' . $s;
        }
        return substr($str, 1);
    }

    public static function hasStatus($status)
    {
        return Member::all()->filter(function ($value) use ($status) {
            $condition = in_array($status, $value->status);
            return $condition;
        });
    }
}
