<?php

namespace App\Services;

use App\Exceptions\StudentServiceException;
use App\Mail\StudentVerificationMail;
use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function createStudent(User $user, array $courses)
    {
        try {
            return $this->studentRepository->createStudent($user, $courses);
        } catch (\Exception $exception) {
            throw new StudentServiceException('Error Creating student.', 500, $exception);
        }
    }

    public function updateStudent(User $user, array $data): User
    {
        return $this->studentRepository->updateStudent($user, $data);
    }

    public function deleteStudent(User $user): bool
    {
        return $this->studentRepository->deleteStudent($user);
    }

    public function getUserById(int $id): User
    {
        return $this->studentRepository->getUserById($id);
    }

    public function getAllCourses(): Collection
    {
        return $this->studentRepository->getAllCourses();
    }

    public function sendVerificationEmail(User $user): void
    {
        $verificationToken = Str::random(40); // Generate a verification token

        // Save the verification token to the user's record
        $user->verification_token = $verificationToken;

        try {
            $this->studentRepository->saveUser($user);
            Mail::to($user->email)->send(new StudentVerificationMail($user));
        } catch (\Exception $e) {
            throw new StudentServiceException('Failed to send verification email.', $e->getCode(), $e);
        }
    }

    public function getUserByVerificationToken(string $token): User
    {
        try {
            return $this->studentRepository->getUserByVerificationToken($token);
        } catch (\Exception $e) {
            throw new StudentServiceException('Failed to retrieve user by verification token.', $e->getCode(), $e);
        }
    }

    public function updateActivation(User $user): void
    {
        try {
            $this->studentRepository->updateActivation($user);
        } catch (\Exception $e) {
            throw new StudentServiceException('Failed to update student activation.', $e->getCode(), $e);
        }
    }

    public function updateRank(Student $student, int $newRank): void
    {
        try {
            $this->studentRepository->updateRank($student, $newRank);
        } catch (\Exception $e) {
            throw new StudentServiceException('Failed to update student rank.', $e->getCode(), $e);
        }
    }

}
