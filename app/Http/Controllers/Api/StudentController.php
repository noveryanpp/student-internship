<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();

        return new StudentResource(true, 'Students Data Fetched Successfully', $students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:1',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'nis' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Student::class, 'email'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::create($request->all());

        return new StudentResource(true, 'Student Created Successfully', $student);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        if(!$student)
        {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        return new StudentResource(true, 'Student Data Fetched Successfully', $student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if(!$student)
        {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:1',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'nis' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Student::class, 'email')->ignore($student->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student->update($request->all());

        return new StudentResource(true, 'Student Updated Successfully', $student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if(!$student)
        {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        if($student->internships()->count() > 0 || $student->internship_requests()->count() > 0) {
            return response()->json(['message' => 'Cannot delete a student with internships data'], 400);
        }

        $student->delete();

        return new StudentResource(true, 'Student Deleted Successfully', $student);
    }
}
