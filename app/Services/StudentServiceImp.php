<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Support\Collection;

class StudentServiceImp implements StudentService
{

    private $studentRepository;

    /**
     * @param $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }


    public function getAllStudents(): Collection
    {
        // TODO: Implement getAllStudents() method.
        return $this->studentRepository->getAllStudents();

    }
}
