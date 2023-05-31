<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 0)->get(); // Retrieve only students

        return view('students.index', compact('students'));
    }

    public function index2()
    {
        $students = User::where('role', 0)->get();
        return view('students2', compact('students'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ]);

        // Check if email already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'The email already exists.');
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 0,
        ]);

        // Attach courses to the user
        $user->courses()->attach($request->courses);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }



    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function edit($id)
    {
        $student = User::where('role', 0)->findOrFail($id);
        $courses = Course::all();

        return view('students.edit', compact('student', 'courses'));
    }

//    public function checkEmail(Request $request)
//    {
//        $email = $request->input('email');
//
//        $user = User::where('email', $email)->first();
//
//        if ($user) {
//            return response()->json(['exists' => true]);
//        }
//
//        return response()->json(['exists' => false]);
//    }

    public function update(Request $request, $id)
    {
        $student = User::where('role', 0)->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $student->name = $request->name;
        $student->email = $request->email;
        $student->courses()->sync($request->courses);

        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->where('role', 0)->firstOrFail();
        return view('students.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->where('role', 0)->firstOrFail();
        $user->courses()->detach(); // Remove the student from all courses
        $user->delete(); // Delete the student
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
