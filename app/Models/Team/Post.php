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

    public function approver() {
        return $this->belongsTo('App\Models\Team\Member','approved_by');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Team\Tag', 'posts_tags');
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
        return route('admins.approve-post',['post' => $this]);
    }

    public function getLinkToDelete()
    {
        return route('posts.destroy', ['post' => $this]);
    }


    public function small_part()
    {
        return \Str::limit($this->get_content(),30);
    }

    public function get_content()
    {
        return str_replace('`','\`', $this->content ?? $this->content_before_review);
    }

    public static function all_for_member(Member $member = null)
    {
        if (is_null($member)) {
            $member_posts = collect();
        }
        else {
            $member_posts = $member->posts();
        }
        $posts = Post::where('state', '>',config('team.posts.status.DRAFT'));
        $posts = $posts->union($member_posts);
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
        return !is_null($this->rate);
    }

    public function with_link()
    {
        return !is_null($this->fb_link);
    }
}
