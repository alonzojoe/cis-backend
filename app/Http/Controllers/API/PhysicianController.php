<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Physician;

class PhysicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function all()
    {
        $physician = Physician::where(['status' => 1])
            ->orderBy('lname', 'asc')
            ->get();

        return response()->json(['data' => $physician, 'message' => 'List of Physicians'], 200);
    }

    public function index(Request $request)
    {
        $license_no = $request->input('license_no');
        $lname = $request->input('lname');
        $fname = $request->input('fname');
        $mname = $request->input('mname');

        $perPage = $request->input('perPage', 10);

        $query = Physician::query();

        if ($license_no) {
            $query->where('license_no', 'like', '%' . $license_no . '%');
        }

        if ($lname) {
            $query->where('lname', 'like', '%' . $lname . '%');
        }

        if ($fname) {
            $query->where('fname', 'like', '%' . $fname . '%');
        }

        if ($mname) {
            $query->where('mname', 'like', '%' . $mname . '%');
        }

        $query->orderBy('id', 'desc');
        $results = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $results->items(),
            'total_pages' => $results->lastPage(),
            'total' => $results->total()
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_no' => 'nullable|string',
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'mname' => 'nullable|string',
        ]);

        $physician = Physician::create([
            'license_no' => $request->license_no,
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
        ]);

        return response()->json(['data' => $physician, 'message' => 'Physician Created Successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'license_no' => 'nullable|string',
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'mname' => 'nullable|string',
        ]);

        $physician = Physician::findOrFail($id);
        $physician->update([
            'license_no' => $request->license_no,
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
        ]);

        return response()->json(['data' => $physician, 'message' => 'Physician Updated Successfully'], 200);
    }

    public function inactive($id)
    {
        $physician = Physician::findOrFail($id);
        $physician->update(['status' => 0]);

        return response()->json(['data' => $physician, 'message' => 'Physician Set to Inactive'], 200);
    }
}
