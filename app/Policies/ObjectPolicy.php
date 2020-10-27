<?php

namespace App\Policies;

use App\User;
use App\Object;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the object.
     *
     * @param  \App\User  $user
     * @param  \App\Object  $object
     * @return mixed
     */
    public function view(User $user, Object $object)
    {
        //
    }

    /**
     * Determine whether the user can create objects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the object.
     *
     * @param  \App\User  $user
     * @param  \App\Object  $object
     * @return mixed
     */
    public function update(User $user, Object $object)
    {
        $polices = $user->polices;
        foreach ($polices as $police) {
            if($police->id == 2) {
                return true;
            }
        }
        return false;
    }

    public function softdelete(User $user)
    {
        return $user->role->name == "rieltor";
    }

    /**
     * Determine whether the user can delete the object.
     *
     * @param  \App\User  $user
     * @param  \App\Object  $object
     * @return mixed
     */
    public function delete(User $user, Object $object)
    {
        //
    }
}
