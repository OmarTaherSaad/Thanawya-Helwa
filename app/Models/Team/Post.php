<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    protected $fillable= [
        'content_before_review','content','fb_link','state','rate'
    ];

    public function writer() {
        return $this->belongsTo('App\Models\Team\Member','written_by');
    }

    public function cowriter() {
        return $this->belongsTo('App\Models\Team\Member', 'cowriter_id');
    }

    public function approver() {
        return $this->belongsTo('App\Models\Team\Member','approved_by');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Team\Tag', 'posts_tags');
    }

    public function hasCowriter()
    {
        return !is_null($this->cowriter);
    }

    public function belongTo(\App\User $user)
    {
        return !is_null($this->writer) && $this->writer->is($user->member);
    }

    public function isEditable()
    {
        return $this->state == config('team.posts.status.DRAFT');
    }

    public function getLinkToView()
    {
        return route('posts.show', ['post' => $this]);
    }

    public function getLinkToEdit()
    {
        return route('posts.edit', ['post' => $this]);
    }

    public function getLinkToUpdate()
    {
        return route('posts.update', ['post' => $this]);
    }

    public function getLinkToApprove()
    {
        return route('posts.approve',['post' => $this]);
    }

    public function getLinkToDelete()
    {
        return route('posts.destroy', ['post' => $this]);
    }

    public function getLinkToForceDelete()
    {
        return route('posts.forceDelete', ['post' => $this]);
    }

    public function getLinkToRestore()
    {
        return route('posts.restore', ['post' => $this]);
    }


    public function small_part()
    {
        return \Str::limit($this->get_content(),20);
    }

    public function get_content()
    {
        return str_replace('`','\`', $this->content ?? $this->content_before_review);
    }

    public static function all_for_member(Member $member = null,$MemberOnly = false)
    {
        if (is_null($member)) {
            $member_posts = collect();
            $member_coposts = collect();
        }
        else {
            $member_posts = $member->posts();
            $member_coposts = $member->coposts();
        }
        $posts = Post::where('state', '>',config('team.posts.status.DRAFT'));
        if($MemberOnly) {
            $posts = $member_posts->union($member_coposts);
        } else {
            $posts = $posts->union($member_posts)->union($member_coposts);
        }
        return $posts->orderBy('updated_at', 'desc')->paginate(config('app.pagination_max'));
    }
    public static function all_for_public()
    {
        $posts = Post::where('state',config('team.posts.status.POSTED'));
        return $posts->orderBy('updated_at', 'desc')->paginate(config('app.pagination_max'));
    }

    public function getStatusAttribute()
    {
        return \Str::title(str_replace('_', ' ', array_search($this->state, config('team.posts.status'))));
    }

    public function approved()
    {
        return $this->state >= config('team.posts.status.APPROVED');
    }

    public function posted()
    {
        return $this->state == config('team.posts.status.POSTED');
    }

    public function rated()
    {
        return !is_null($this->rate) && $this->approved();
    }

    public function with_link()
    {
        return isset($this->fb_link) && $this->posted();
    }

    public function getPercentageAttribute()
    {
        similar_text($this->content, $this->content_before_review, $perc);
        return round($perc,2);
    }

    public static function getStatesForFilter()
    {
        $states = collect(config('team.posts.status'))->keys()->transform(function ($s) {
            return ['key' => $s, 'value' => \Str::title(str_replace('_', ' ', $s))];
        })->keyBy('key')->transform(function ($s) {
            return $s['value'];
        });
        return $states;
    }
}
