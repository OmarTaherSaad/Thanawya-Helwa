<?php

namespace App\Policies;

use App\Quiz;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if (\Auth::check() && \Auth::user()->isAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any quizzes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function view(User $user, Quiz $quiz)
    {
        if ($user == null) {
            return isset($quiz->revised);
        }
        return $user->isTeamMember() && ($user->member->is($quiz->maker) || $user->member->is($quiz->revisor) || $user->member->is($quiz->inserter));
    }

    /**
     * Determine whether the user can create quizzes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isTeamMember();
    }

    /**
     * Determine whether the user can update the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function update(User $user, Quiz $quiz)
    {
        return $user->isTeamMember() && ($user->member->is($quiz->maker) || $user->member->is($quiz->revisor) || $user->member->is($quiz->inserter));
    }

    public function revise(User $user, Quiz $quiz)
    {
        return $user->isTeamMember() && $user->member->is($quiz->revisor);
    }

    /**
     * Determine whether the user can delete the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function delete(User $user, Quiz $quiz)
    {
        return $user->isTeamMember() && $user->member->is($quiz->inserter);
    }

    /**
     * Determine whether the user can restore the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function restore(User $user, Quiz $quiz)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function forceDelete(User $user, Quiz $quiz)
    {
        return false;
    }
}
