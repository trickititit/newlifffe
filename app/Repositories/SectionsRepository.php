<?php

namespace App\Repositories;

use App\Section;

use Gate;

class SectionsRepository extends Repository {

    public function __construct(Section $section) {
        $this->model = $section;
    }
}

?>