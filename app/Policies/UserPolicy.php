<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewContacts(User $user)
    {
        $polices = $user->polices;
        foreach ($polices as $police) {
            if($police->id == 3) {
                return true;
            }
        }
        return false;
    }

    public function viewAvito(User $user)
    {
        $polices = $user->polices;
        foreach ($polices as $police) {
            if($police->id == 1) {
                return true;
            }
        }
        return false;
    }

    public function editPolice(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}
