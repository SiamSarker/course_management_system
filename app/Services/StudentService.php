<?php

namespace App\Services;
use Illuminate\Support\Collection;

interface StudentService
{
    public function getAllStudents(): Collection;
}
