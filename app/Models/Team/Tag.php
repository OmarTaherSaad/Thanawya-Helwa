<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Models\Team\Post','posts_tags');
    }

    public function getLinkToView()
    {
        return route('tags.show', ['tag' => $this]);
    }

    public function getLinkToEdit()
    {
        return route('tags.edit', ['tag' => $this]);
    }

    public function getLinkToUpdate()
    {
        return route('tags.update', ['tag' => $this]);
    }
    public function getLinkToDelete()
    {
        return route('tags.destroy', ['tag' => $this]);
    }
}
