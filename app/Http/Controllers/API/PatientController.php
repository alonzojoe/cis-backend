<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PastHistory;
use App\Models\FamilyHistory;
use App\Models\SocialHistory;
use App\Models\Patient;
use App\Models\ConsultationHistory;
use App\Models\VitalSigns;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    public function concierge(Request $request)
    {
        try {
            $consultation_no = $request->input('consultation_no');
            $lname = $request->input('lname');
            $fname = $request->input('fname');
            $mname = $request->input('mname');
            $birthdate = $request->input('birthdate');
            $payment_type = $request->input('payment_type');
            $currentDate = now()->toDateString();
            $perPage = $request->input('perPage', 10);

            $query = ConsultationHistory::query();
            $query->where('ch.status', '=', 1);
            $query->whereDate('ch.consultation_datetime', $currentDate);

            if ($consultation_no) {
                $query->where('ch.consultation_no', 'like', '%' . $consultation_no . '%');
            }

            if ($lname) {
                $query->where('p.lname', 'like', '%' . $lname . '%');
            }

            if ($fname) {
                $query->where('p.fname', 'like', '%' . $fname . '%');
            }

            if ($mname) {
                $query->where('p.mname', 'like', '%' . $mname . '%');
            }

            if ($birthdate) {
                $query->where('p.birthdate', 'like', '%' . $birthdate . '%');
            }

            if ($payment_type) {
                $query->where('ch.payment_type', 'like', '%' . $payment_type . '%');
            }

            $query->orderBy('ch.id', 'desc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->join('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
            $query->select(
                'ch.id AS consultation_id',
                'p.lname AS patient_lname',
                'p.fname AS patient_fname',
                'p.mname AS patient_mname',
                'p.suffix AS patient_suffix',
                'ch.created_at AS ch_created_at',
                'ch.updated_at AS ch_updated_at',
                'ch.*',
                'p.*',
                'phy.*',
                DB::raw('CONCAT(phy.fname, " ", IF(phy.lname IS NULL OR phy.mname = "", "", CONCAT(SUBSTRING(phy.mname, 1, 1), ". ")), phy.lname) AS physician')
            )->from('consultation_history AS ch');
            $results = $query->paginate($perPage);
            return response()->json([
                'status' => 'success',
                'data' => $results->items(),
                'total_pages' => $results->lastPage(),
                'total' => $results->total()
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No Patient Found' . $e], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong' . $e], 500);
        }
    }

    public function masterfile(Request $request)
    {
        try {
            $consultation_no = $request->input('consultation_no');
            $lname = $request->input('lname');
            $fname = $request->input('fname');
            $mname = $request->input('mname');
            $birthdate = $request->input('birthdate');
            $payment_type = $request->input('payment_type');
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $perPage = $request->input('perPage', 10);

            $query = ConsultationHistory::query();
            $query->where('ch.status', '=', 1);

            if ($consultation_no) {
                $query->where('ch.consultation_no', 'like', '%' . $consultation_no . '%');
            }

            if ($lname) {
                $query->where('p.lname', 'like', '%' . $lname . '%');
            }

            if ($fname) {
                $query->where('p.fname', 'like', '%' . $fname . '%');
            }

            if ($mname) {
                $query->where('p.mname', 'like', '%' . $mname . '%');
            }

            if ($birthdate) {
                $query->where('p.birthdate', 'like', '%' . $birthdate . '%');
            }

            if ($payment_type) {
                $query->where('ch.payment_type', 'like', '%' . $payment_type . '%');
            }

            if ($date_from && $date_to) {
                $query->whereDate('ch.consultation_datetime', '>=', $date_from)->whereDate('ch.consultation_datetime', '<=', $date_to);
            }

            $query->orderBy('ch.id', 'desc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->join('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
            $query->select(
                'ch.id AS consultation_id',
                'p.lname AS patient_lname',
                'p.fname AS patient_fname',
                'p.mname AS patient_mname',
                'p.suffix AS patient_suffix',
                'ch.created_at AS ch_created_at',
                'ch.updated_at AS ch_updated_at',
                'ch.*',
                'p.*',
                'phy.*',
                DB::raw('CONCAT(phy.fname, " ", IF(phy.lname IS NULL OR phy.mname = "", "", CONCAT(SUBSTRING(phy.mname, 1, 1), ". ")), phy.lname) AS physician')
            )->from('consultation_history AS ch');
            $results = $query->paginate($perPage);
            return response()->json([
                'status' => 'success',
                'data' => $results->items(),
                'total_pages' => $results->lastPage(),
                'total' => $results->total()
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No Patient Found' . $e], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong' . $e], 500);
        }
    }

    public function inactive($id)
    {
        $consultation = ConsultationHistory::findOrFail($id);
        $consultation->update([
            'status' => 0
        ]);

        return response()->json(['data' => $consultation, 'message', 'Patient is Set to Inactive'], 200);
    }
}
