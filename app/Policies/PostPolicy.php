<?php

namespace App\Policies;

use App\Models\Team\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function before($user,$ability)
    {
        if (\Auth::check() && \Auth::user()->isAdmin() && !in_array($ability, ['approve', 'approve_post'])) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(?User $user, Post $post)
    {
        if ($user == null)
        {
            return $post->posted();
        }
        return ($user->isTeamMember() && $user->member->is($post->writter)) || $post->state == config('team.posts.status.UNDER_REVIEW');
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isTeamMember();
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->isTeamMember() && $post->belongTo($user) && $post->isEditable();
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->isTeamMember() && $post->belongTo($user) && $post->isEditable();
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return false;
    }

    public function approve(User $user, Post $post)
    {
        return false;
    }
    public function approve_post(User $user, Post $post)
    {
        return false;
    }
    public function all_post_for_admin()
    {
        return false;
    }
}
