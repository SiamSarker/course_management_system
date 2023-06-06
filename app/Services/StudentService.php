<?php

namespace App\Services;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;

interface StudentService
{
    public function getAllStudents(): Collection;
    public function createStudent(User $user, array $courses);
    public function updateStudent(User $user, array $data): User;
    public function deleteStudent(User $user): bool;
    public function getUserById(int $id): User;
    public function getAllCourses(): Collection;
    public function sendVerificationEmail(User $user): void;
    public function getUserByVerificationToken(string $token): User;
    public function updateActivation(User $user): void;
    public function updateRank(Student $student, int $newRank): void;
}
