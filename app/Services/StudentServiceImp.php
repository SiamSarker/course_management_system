<?php

namespace App\Services;

use App\Exceptions\StudentServiceException;
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
//        throw new StudentServiceException('Error retrieving students.');
        try {
            return $this->studentRepository->getAllStudents();
        } catch (\Exception $exception) {
            throw new StudentServiceException('Error retrieving students.', 500, $exception);
        }
    }
}
