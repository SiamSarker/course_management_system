<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 0)->with(['student' => function ($query) {
            $query->orderBy('students.rank', 'asc');
        }])->get();

//        $students = DB::table("users")->join("students", "users.id", "=", "students.user_id")
//            ->join("courses", "users.id", "=", "courses.user_id")
//            ->orderBy('rank', 'asc')->get();
//dd($students);



        // Retrieve only students
//        dd($students);

//        foreach ($students as $student) {
//            $user = $student; // User details
//            $student = $student->student; // Student details
//            dd($user, $student);
//
//            // Perform any desired operations with $user and $student
//        }


//        return view('students.index', compact('students'));
        return view('students.index')->with('students', $students);

    }

    public function updateRank(Request $request, Student $student)
    {
        $request->validate([
            'rank' => 'required|integer',
        ]);

        $student->update([
            'rank' => $request->rank,
        ]);

        return redirect()->route('students.index')->with('success', 'Rank updated successfully.');
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

        $existingStudentCount = Student::count();

        // Create new student with rank 0
        $student = new Student([
            'rank' => $existingStudentCount + 1,
        ]);

        // Save the student record and associate it with the user
        $user->student()->save($student);

        // Attach courses to the student
        $student->courses()->attach($request->courses);

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

    public function update(Request $request, $id)
    {
        $user = User::where('role', 0)->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

                // Create new student with rank 0
        $student = new Student([
            'rank' => 0,
        ]);

        // Save the student record and associate it with the user
        $user->student()->save($student);

        // Attach courses to the student
        $student->courses()->attach($request->courses);

        $user->courses()->sync($request->courses);

        $user->save();

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

        $user->student->courses()->detach(); // Remove the student from all courses
        $user->courses()->detach(); // Remove the users from all courses

        $user->student()->delete();
        $user->delete(); // Delete the student
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
