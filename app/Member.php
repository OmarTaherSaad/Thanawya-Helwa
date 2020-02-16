<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Member extends User implements HasMedia
{
    use HasMediaTrait;


    protected $fillable = ['title','education','text','name','status'];

    protected $casts = [
        'status' => 'array'
    ];

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

    public function registerMediaCollections()
    {
        $this->addMediaCollection('profile-photo')
            ->useFallbackUrl(asset('storage/members/default.jpg'))
            ->useFallbackPath(asset('storage/members/default.jpg'))
            ->singleFile();
    }

    public static function hasStatus($status)
    {
        return Member::all()->filter(function($value) use ($status) {
            $condition = in_array($status, $value->status) && ($status == 'founder' || !in_array('founder', $value->status));
            return $condition;
        });
    }
}
