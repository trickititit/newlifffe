<?php

namespace App\Repositories;

use Gate;
use App\Area;

class AreasRepository extends Repository
{
    public function __construct(Area $area)
    {
        $this->model = $area;
    }
}
