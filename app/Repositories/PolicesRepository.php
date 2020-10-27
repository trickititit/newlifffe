<?php
/**
 * Created by PhpStorm.
 * User: ANDREEV
 * Date: 05.10.2017
 * Time: 13:32
 */

namespace App\Repositories;

use App\Police;

class PolicesRepository extends Repository {

    public function __construct(Police $police) {
        $this->model = $police;
    }

}