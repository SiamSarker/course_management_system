<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Course;
use \App\Models\StudentCourse;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    function index()
    {
        $studentId = 1;
        $student = Student::find($studentId);
        echo $student->name;
        echo "<br><br>";

        $courses = $student->courses;

// You can now loop through the $courses collection and display the course details
        foreach ($courses as $course) {
            echo "Course ID: " . $course->id . "<br>";
            echo "Course Name: " . $course->name . "<br>";
            // Add any other course details you want to display
            echo "<br>";
        }
    }

    public function test()
    {
        $response = [
            'user' => "Hello From",
            'token' => "StudentCourse controller"
        ];

        return response($response, 202);
    }
}
