<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndustryResource;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industries = Industry::latest()->get();

        return new IndustryResource(true, 'Industries Data Fetched Successfully', $industries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'email|max:255',
            'website' => 'url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $industry = Industry::create($request->all());

        return new IndustryResource(true, 'Industry Created Successfully', $industry);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $industry = Industry::find($id);

        if(!$industry)
        {
            return response()->json(['message' => 'Industry Not Found'], 404);
        }

        return new IndustryResource(true, 'Industry Data Fetched Successfully', $industry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $industry = Industry::find($id);

        if(!$industry)
        {
            return response()->json(['message' => 'Industry Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'email|max:255',
            'website' => 'url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $industry->update($request->all());

        return new IndustryResource(true, 'Industry Updated Successfully', $industry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $industry = Industry::find($id);

        if(!$industry)
        {
            return response()->json(['message' => 'Industry Not Found'], 404);
        }

        if($industry->internships()->count() > 0 || $industry->internship_requests()->count() > 0) {
            return response()->json(['message' => 'Cannot delete an industry with internships data'], 400);
        }

        $industry->delete();

        return new IndustryResource(true, 'Industry Deleted Successfully', $industry);
    }
}
