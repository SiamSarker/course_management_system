<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Response;
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

        return view('students.index')->with('students', $students);

    }

    public function getTableData()
    {
        $students = User::where('role', 0)->with(['student' => function ($query) {
            $query->orderBy('students.rank', 'asc');
        }])->get();

        return view('students.table', compact('students'));
    }



    public function updateRank(Request $request, Student $student)
    {
        $newRank = $request->rank;

        // Return an error if the new rank is not a positive integer
        if ($newRank < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Rank should be a positive integer',
            ]);
        }

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

        return response()->json([
            'success' => true,
        ]);
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

        $highestRank = Student::max('rank');

// Create a new student with rank one higher than the highest rank
        $student = new Student([
            'rank' => $highestRank + 1,
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
