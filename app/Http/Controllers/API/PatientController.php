<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\ConsultationHistory;
use App\Models\VitalSigns;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
                $query->where('p.birthdate', '=',  $birthdate);
            }


            if ($payment_type) {
                $query->where('ch.payment_type', '=', $payment_type);
            }

            $query->orderBy('ch.consultation_datetime', 'desc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->leftJoin('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
            $query->select(
                'ch.id AS consultation_id',
                'p.lname AS patient_lname',
                'p.fname AS patient_fname',
                'p.mname AS patient_mname',
                'p.suffix AS patient_suffix',
                'ch.status as consultation_status',
                'ch.created_at AS ch_created_at',
                'ch.updated_at AS ch_updated_at',
                'ch.*',
                'p.*',
                'phy.*',
                DB::raw('CONCAT(phy.lname, ", ", phy.fname, IFNULL(CONCAT(" ", phy.mname), "")) AS physician')
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

    public function showConsultation($id)
    {
        try {


            $query = ConsultationHistory::query();
            $query->where('ch.id', '=', $id);
            $query->orderBy('ch.id', 'desc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->leftJoin('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
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
                DB::raw('CONCAT(phy.lname, ", ", phy.fname, IFNULL(CONCAT(" ", phy.mname), "")) AS physician')
            )->from('consultation_history AS ch');
            $results = $query->first();
            return response()->json([
                'status' => 'success',
                'data' => $results,
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
                $query->where('p.birthdate', '=',  $birthdate);
            }

            if ($payment_type) {
                $query->where('ch.payment_type', '=', $payment_type);
            }

            if ($date_from && $date_to) {
                $query->whereDate('ch.consultation_datetime', '>=', $date_from)->whereDate('ch.consultation_datetime', '<=', $date_to);
            }

            $query->orderBy('ch.consultation_datetime', 'desc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->leftJoin('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
            $query->select(
                'ch.id AS consultation_id',
                'p.lname AS patient_lname',
                'p.fname AS patient_fname',
                'p.mname AS patient_mname',
                'p.suffix AS patient_suffix',
                'ch.status as consultation_status',
                'ch.created_at AS ch_created_at',
                'ch.updated_at AS ch_updated_at',
                'ch.*',
                'p.*',
                'phy.*',
                DB::raw('CONCAT(phy.lname, ", ", phy.fname, IFNULL(CONCAT(" ", phy.mname), "")) AS physician')
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

    public function report(Request $request)
    {
        try {

            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');

            $query = ConsultationHistory::query();
            $query->where('ch.status', '=', 1);

            if ($date_from && $date_to) {
                $query->whereDate('ch.consultation_datetime', '>=', $date_from)->whereDate('ch.consultation_datetime', '<=', $date_to);
            }

            $query->orderBy('ch.consultation_datetime', 'asc');
            $query->join('patients AS p', 'ch.patient_id', '=', 'p.id')
                ->leftJoin('physicians AS phy', 'ch.physician_id', '=', 'phy.id');
            $query->select(
                'ch.id AS consultation_id',
                'ch.consultation_no',
                'ch.consultation_datetime',
                'p.lname AS patient_lname',
                'p.fname AS patient_fname',
                'p.mname AS patient_mname',
                'p.suffix AS patient_suffix',
                'ch.status as consultation_status',
                'ch.assessment AS diagnosis',
                'ch.payment_type',
                'ch.created_at AS ch_created_at',
                'ch.updated_at AS ch_updated_at',
                DB::raw('CONCAT(p.lname, ", ", p.fname, IFNULL(CONCAT(" ", p.mname), ""), IFNULL(CONCAT(" ", p.suffix), "")) AS patient'),
                DB::raw('CONCAT(phy.lname, ", ", phy.fname, IFNULL(CONCAT(" ", phy.mname), "")) AS physician')
            )->from('consultation_history AS ch');
            $results = $query->get();
            return response()->json([
                'status' => 'success',
                'data' => $results,
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
        $consultation->update(['status' => 0]);

        return response()->json(['data' => $consultation, 'message' => 'Consultation Set to Inactive'], 200);
    }

    public function active($id)
    {
        $consultation = ConsultationHistory::findOrFail($id);
        $consultation->update(['status' => 1]);

        return response()->json(['data' => $consultation, 'message' => 'Consultation Set to Active'], 200);
    }

    public function searchPatient(Request $request)
    {
        $lname = $request->input('lname');
        $fname = $request->input('fname');
        $mname = $request->input('mname');
        $birthdate = $request->input('birthdate');

        $query = Patient::query();

        if ($lname) {
            $query->where('lname', 'like', '%' . $lname . '%');
        }

        if ($fname) {
            $query->where('fname', 'like', '%' . $fname . '%');
        }

        if ($mname) {
            $query->where('mname', 'like', '%' . $mname . '%');
        }

        if ($birthdate) {
            $query->where('birthdate', '=', $birthdate);
        }

        $query->orderBy('id', 'desc');
        $results = $query->take(10)->get();
        return response()->json([
            'status' => 'success',
            'data' => $results,
        ], 200);
    }

    public function getLatestConsultationHistory($id)
    {
        $patient = Patient::findOrFail($id);
        $latestConsultation = $patient->consultationHistories()->latest()->first();
        $vitalSigns = VitalSigns::where('consultation_id', '=', $latestConsultation->id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $vitalSigns,
        ], 200);
    }

    public function history($id)
    {
        $history = Patient::where('id', '=', $id)
            ->with([
                'consultationHistories' => function ($query) {
                    $query->select(
                        'consultation_history.id AS consultation_id',
                        'consultation_history.*',
                        'physicians.*',
                        DB::raw('CONCAT(physicians.lname, ", ", physicians.fname, IFNULL(CONCAT(" ", physicians.mname), "")) AS physician')
                    )->join('physicians', 'consultation_history.physician_id', '=', 'physicians.id');
                }
            ])->get();

        return response()->json([
            'data' => $history,
            'message' => 'Consultation History Retrieved',
        ], 200);
    }
}
