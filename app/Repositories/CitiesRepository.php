<?php

namespace App\Repositories;

use App\City;

use Gate;

class CitiesRepository extends Repository {

    public function __construct(City $city) {
        $this->model = $city;
    }
}

?>