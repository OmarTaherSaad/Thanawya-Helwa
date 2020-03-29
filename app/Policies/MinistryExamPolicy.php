<?php

namespace App\Policies;

use App\MinistryExam;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MinistryExamPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin())
        {
            return true;
        }
    }
    /**
     * Determine whether the user can view any ministry exams.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the ministry exam.
     *
     * @param  \App\User  $user
     * @param  \App\MinistryExam  $ministryExam
     * @return mixed
     */
    public function view(?User $user, MinistryExam $ministryExam)
    {
        return true;
    }

    /**
     * Determine whether the user can create ministry exams.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isTeamMember();
    }

    /**
     * Determine whether the user can update the ministry exam.
     *
     * @param  \App\User  $user
     * @param  \App\MinistryExam  $ministryExam
     * @return mixed
     */
    public function update(User $user, MinistryExam $ministryExam)
    {
        return $user->isTeamMember() && $ministryExam->adder->is($user->member);
    }

    /**
     * Determine whether the user can delete the ministry exam.
     *
     * @param  \App\User  $user
     * @param  \App\MinistryExam  $ministryExam
     * @return mixed
     */
    public function delete(User $user, MinistryExam $ministryExam)
    {
        return $user->isTeamMember() && $ministryExam->adder->is($user->member);
    }
}
