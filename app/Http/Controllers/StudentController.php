<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = new Student();
        $student->name = $validatedData['name'];
        $student->save();

        $courseId = $validatedData['course_id'];
        $student->courses()->attach($courseId);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $availableCourses = Course::whereNotIn('id', $student->courses->pluck('id'))->get();

        return view('students.edit', compact('student', 'availableCourses'));
    }

//    public function create()
//    {
//        return view('students.create');
//    }
//
//    public function store(Request $request)
//    {
//        $student = Student::create($request->all());
//        return redirect()->route('students.index')->with('success', 'Student created successfully!');
//    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

//    public function edit(Student $student)
//    {
//        return view('students.edit', compact('student'));
//    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
