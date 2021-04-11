<?php

namespace App\Repositories;

use Gate;
use App\Section;

class SectionsRepository extends Repository
{
    public function __construct(Section $section)
    {
        $this->model = $section;
    }
}
