<?php
namespace App\Http\Controllers;

use App\Exceptions\StudentServiceException;
use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Mail\StudentVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



class StudentController extends Controller
{

    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        try {
            $students = $this->studentService->getAllStudents();
            return view('students.index')->with('students', $students);
        } catch (StudentServiceException $e) {
            return view('students.error')->with('error', $e->getMessage());
        }
    }

    public function index2()
    {
        try {
            $students = $this->studentService->getAllStudents();
            return view('students2')->with('students', $students);
        } catch (StudentServiceException $e) {
            return view('students.error')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $courses = $this->studentService->getAllCourses();

            return view('students.create', compact('courses'));
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
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

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 0,
            ]);

            $user = $this->studentService->createStudent($user, $request->input('courses'));

            $this->sendVerificationEmail($user);

            return redirect()->route('students.index')->with('success', 'Student created successfully. An email has been sent for verification.');
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function edit($id )
    {
        try {
            $student = $this->studentService->getUserById($id);
            $courses = $this->studentService->getAllCourses();

            return view('students.edit', compact('student', 'courses'));
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->studentService->getUserById($id);

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'courses' => 'nullable|array',
                'courses.*' => 'exists:courses,id',
            ]);

            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'courses' => $request->input('courses', []),
            ];

            $user = $this->studentService->updateStudent($user, $data);

            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->where('role', 0)->firstOrFail();

            $this->studentService->deleteStudent($user);

            return redirect()->route('students.index')->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $user = $this->studentService->getUserById($id);

            return view('students.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }


    public function sendVerificationEmail(User $user)
    {
        try {
            $this->studentService->sendVerificationEmail($user);
            return redirect()->back()->with('success', 'Verification email sent successfully.');
        } catch (StudentServiceException $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function verify($token)
    {
        try {
            $user = $this->studentService->getUserByVerificationToken($token);
            return view('students.activate')->with('user', $user);
        } catch (StudentServiceException $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function updateActivation(Request $request, User $user)
    {
        try {
            $this->studentService->updateActivation($user);
            return redirect()->route('students.index')->with('success', 'Your student account has been activated successfully.');
        } catch (StudentServiceException $e) {
            return redirect()->route('students.error')->with('error', $e->getMessage());
        }
    }

    public function updateRank(Request $request, Student $student)
    {
        try {
            $newRank = $request->rank;
            $this->studentService->updateRank($student, $newRank);
            return response()->json([
                'success' => true,
            ]);
        } catch (StudentServiceException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


}
