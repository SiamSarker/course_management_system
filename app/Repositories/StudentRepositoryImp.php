<?php

namespace App\Repositories;

use App\Exceptions\StudentServiceException;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;

class StudentRepositoryImp implements StudentRepository
{

    public function getAllStudents(): Collection
    {
        // TODO: Implement getAllStudents() method.
        try {
            return User::where('role', 0)
                ->where('verified_student', 1)
                ->get()
                ->sortBy(function ($user) {
                    return optional($user->student)->rank;
                });
        } catch (\Exception $e) {
            throw new StudentServiceException('Error retrieving students.', 500, $e);
        }
    }

    public function createStudent(User $user, array $courses)
    {
        $highestRank = Student::max('rank');

        $student = new Student([
            'rank' => $highestRank + 1,
        ]);

        $user->student()->save($student);

        $student->courses()->attach($courses);

        $user->courses()->attach($courses);

        return $user->fresh();
    }

    public function updateStudent(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Update the student's courses
        $user->student->courses()->sync($data['courses']);

        $user->save();

        return $user;
    }

    public function deleteStudent(User $user): bool
    {
        $user->student->courses()->detach(); // Remove the student from all courses
        $user->courses()->detach(); // Remove the user from all courses

        $user->student()->delete(); // Delete the student
        $user->delete(); // Delete the user

        return true;
    }

    public function getUserById(int $id): User
    {
        return User::where('id', $id)->where('role', 0)->firstOrFail();
    }

    public function getAllCourses(): Collection
    {
        return Course::all();
    }

    public function saveUser(User $user): void
    {
        $user->save();
    }

    public function getUserByVerificationToken(string $token): User
    {
        return User::where('verification_token', $token)->firstOrFail();
    }

    public function updateActivation(User $user): void
    {
        $user->verified_student = true;
        $user->save();
    }

    public function updateRank(Student $student, int $newRank): void
    {
        $currentRank = $student->rank;

        if ($newRank != $currentRank) {
            $targetStudent = Student::where('rank', $newRank)->first();

            if (!$targetStudent) {
                $student->update(['rank' => $newRank]);
            } else {
                // Increment ranks if the new rank is higher than the current rank
                if ($newRank > $currentRank) {
                    Student::where('rank', '>', $currentRank)
                        ->where('rank', '<=', $newRank)
                        ->decrement('rank');
                }
                // Decrement ranks if the new rank is lower than the current rank
                else {
                    Student::where('rank', '>=', $newRank)
                        ->where('rank', '<', $currentRank)
                        ->increment('rank');
                }
                $student->update(['rank' => $newRank]);
            }
        }
    }


}
