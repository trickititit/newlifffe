<?php

namespace App\Repositories;

use App\Area;

use Gate;

class AreasRepository extends Repository {

    public function __construct(Area $area) {
        $this->model = $area;
    }
}

?>