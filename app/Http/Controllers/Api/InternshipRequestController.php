<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InternshipRequestResource;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InternshipRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internshipRequests = InternshipRequest::latest()->get();

        return new InternshipRequestResource(true, 'Internship Requests Data Fetched Successfully', $internshipRequests);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'string|max:20',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $internshipRequest = InternshipRequest::create($request->all());

        return new InternshipRequestResource(true, 'Internship Request Created Successfully', $internshipRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $internshipRequest = InternshipRequest::find($id);

        if(!$internshipRequest)
        {
            return response()->json(['message' => 'Internship Request Not Found'], 404);
        }

        return new InternshipRequestResource(true, 'Internship Request Data Fetched Successfully', $internshipRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'student_id.unique' => 'This student already has an internship record.',
        ];

        $internshipRequest = InternshipRequest::find($id);

        if(!$internshipRequest)
        {
            return response()->json(['message' => 'Internship Request Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string|max:20|exists:students,id|unique:internships,student_id',
            'industry_id' => 'required|string|max:20|exists:industries,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'string|max:20',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $internshipRequest->update($request->all());

        return new InternshipRequestResource(true, 'Internship Request Updated Successfully', $internshipRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $internshipRequest = InternshipRequest::find($id);

        if(!$internshipRequest)
        {
            return response()->json(['message' => 'Internship Request Not Found'], 404);
        }

        $internshipRequest->delete();

        return new InternshipRequestResource(true, 'Internship Request Deleted Successfully', $internshipRequest);
    }
}
