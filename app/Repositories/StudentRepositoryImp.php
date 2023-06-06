<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class StudentRepositoryImp implements StudentRepository
{

    public function getAllStudents(): Collection
    {
        // TODO: Implement getAllStudents() method.
        return User::where('role', 0)
            ->where('verified_student', 1)
            ->get()
            ->sortBy(function ($user) {
                return optional($user->student)->rank;
            });
    }
}
