<?php

namespace App\Repositories;

use App\Role;

class RolesRepository extends Repository
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

}
