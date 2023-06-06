<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface StudentRepository
{
    public function getAllStudents(): Collection;

}
