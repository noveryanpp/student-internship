<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InternshipResource;
use App\Models\Internship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internships = Internship::latest()->get();

        return new InternshipResource(true, 'Internships Data Fetched Successfully', $internships);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'student_id.unique' => 'This student already has an internship record.',
        ];

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string|max:20|exists:students,id|unique:internships,student_id',
            'industry_id' => 'required|string|max:20|exists:industries,id',
            'teacher_id' => 'string|max:20|exists:teachers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $internship = Internship::create($request->all());
        Student::where('id', $request->student_id)->update(['internship_status' => '1']);

        return new InternshipResource(true, 'Internship Created Successfully', $internship);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $internship = Internship::find($id);

        if(!$internship)
        {
            return response()->json(['message' => 'Internship Not Found'], 404);
        }

        return new InternshipResource(true, 'Internship Data Fetched Successfully', $internship);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'student_id.unique' => 'This student already has an internship record.',
        ];

        $internship = Internship::find($id);

        if(!$internship)
        {
            return response()->json(['message' => 'Internship Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string|max:20|exists:students,id|unique:internships,student_id,' . $id . ',id',
            'industry_id' => 'required|string|max:20|exists:industries,id',
            'teacher_id' => 'string|max:20|exists:teachers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $internship->update($request->all());

        return new InternshipResource(true, 'Internship Updated Successfully', $internship);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $internship = Internship::find($id);

        if(!$internship)
        {
            return response()->json(['message' => 'Internship Not Found'], 404);
        }

        $internship->delete();
        Student::where('id', $internship->student_id)->update(['internship_status' => '0']);

        return new InternshipResource(true, 'Internship Deleted Successfully', $internship);
    }
}
