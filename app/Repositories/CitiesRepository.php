<?php

namespace App\Repositories;

use Gate;
use App\City;

class CitiesRepository extends Repository
{
    public function __construct(City $city)
    {
        $this->model = $city;
    }
}
