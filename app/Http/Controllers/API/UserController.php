<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $lname = $request->input('lname');
        $fname = $request->input('fname');
        $mname = $request->input('mname');

        $perPage = $request->input('perPage', 10);

        $query = User::query();

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
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'mname' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
            'pw' => $request->password,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['data' => $user, 'message' => 'User Created Successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'mname' => 'nullable|string',
            'password' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
            'pw' => $request->password,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['data' => $user, 'message' => 'User Updated Successfully'], 200);
    }
}
