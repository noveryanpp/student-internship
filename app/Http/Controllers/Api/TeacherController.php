<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::latest()->get();

        return new TeacherResource(true, 'Teachers Data Fetched Successfully', $teachers);
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
            'nip' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Teacher::class, 'email'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $teacher = Teacher::create($request->all());

        return new TeacherResource(true, 'Teacher Created Successfully', $teacher);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::find($id);

        if(!$teacher)
        {
            return response()->json(['message' => 'Teacher Not Found'], 404);
        }

        return new TeacherResource(true, 'Teacher Data Fetched Successfully', $teacher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::find($id);

        if(!$teacher)
        {
            return response()->json(['message' => 'Teacher Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:1',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'nip' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Teacher::class, 'email')->ignore($teacher->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $teacher->update($request->all());

        return new TeacherResource(true, 'Teacher Updated Successfully', $teacher);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::find($id);

        if(!$teacher)
        {
            return response()->json(['message' => 'Teacher Not Found'], 404);
        }

        if($teacher->internships()->count() > 0) {
            return response()->json(['message' => 'Cannot delete a teacher with internships data'], 400);
        }

        $teacher->delete();

        return new TeacherResource(true, 'Teacher Deleted Successfully', $teacher);
    }
}
