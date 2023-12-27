<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\ConsultationHistory;
use App\Models\User;
use App\Models\Physician;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $users = User::count();
        $physicians = Physician::count();
        $patients = Patient::count();
        $active = ConsultationHistory::count();
        $inactive = ConsultationHistory::where('status', 0)->count();
        $tracker = number_format($patients + $active + $inactive);

        $data = [
            'users' => number_format($users),
            'physicians' => number_format($physicians),
            'patients' => number_format($patients),
            'active' => number_format($active),
            'inactive' => number_format($inactive),
            'tracker' => $tracker
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }
}
