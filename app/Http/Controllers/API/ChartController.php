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
use PHPUnit\Runner\AfterTestHook;

class ChartController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function store(Request $request)
    {
        $past_history = PastHistory::create([
            'unremarkable' => $request->unremarkable,
            'blood_disease' => $request->blood_disease,
            'asthma' => $request->asthma,
            'hypertension' => $request->hypertension,
            'cva' => $request->cva,
            'gut_disease' => $request->gut_disease,
            'git_disease' => $request->git_disease,
            'pulmo_disease' => $request->pulmo_disease,
            'previous_or' => strtoupper($request->previous_or),
            'previous_hospitalization' => strtoupper($request->previous_or),
            'other_findings' => strtoupper($request->previous_or),
        ]);

        $family_history = FamilyHistory::create([
            'unremarkable' => $request->f_unremarkable,
            'hcvd' => $request->hcvd,
            'chd' => $request->chd,
            'cva' => $request->cva,
            'gut_disease' => $request->gut_disease,
            'blood_dyscrasia' => $request->blood_dyscrasia,
            'allergy' => $request->allergy,
            'dm' => $request->dm,
            'git_disease' => $request->f_git_disease,
            'pulmo_disease' => $request->f_pulmo_disease,
            'ca' => $request->ca,
            'other_findings' => strtoupper($request->f_other_findings),
        ]);

        $social_history = SocialHistory::create([
            'smoking' => strtoupper($request->smoking),
            'alcohol_intake' => strtoupper($request->alcohol_intake),
            'betel_nut_chewing' => strtoupper($request->betel_nut_chewing),
            'drug_food_allergy' => strtoupper($request->drug_food_allergy),
            'others' => strtoupper($request->others),
        ]);

        $patient = Patient::create([
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'gender' => $request->gender,
            'contact_no' => $request->contact_no,
            'address' => strtoupper($request->address),
            'vaccination' => strtoupper($request->vaccination),
            'past_history_id' => $past_history->id,
            'family_history_id' => $family_history->id,
            'social_history_id' => $social_history->id,
            'created_by' => $request->created_by,
        ]);

        $consultation_history = ConsultationHistory::create([
            'patient_id' => $patient->id,
            'physician_id' => $request->physician_id,
            'consultation_no' => $request->consultation_no,
            'consultation_datetime' => $request->consultation_datetime,
            'payment_type' => $request->payment_type,
            'chief_complaint' => strtoupper($request->chief_complaint),
            'subjective' => strtoupper($request->subjective),
            'objective' => strtoupper($request->objective),
            'assessment' => strtoupper($request->assessment),
            'plan' => strtoupper($request->plan),
            'created_by' => $request->created_by,
        ]);

        $vital_signs = VitalSigns::create([
            'consultation_id' => $consultation_history->id,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $request->bmi,
            'bp_f' => $request->bp_f,
            'bp_s' => $request->bp_s,
            'oxygen_saturation' => $request->oxygen_saturation,
            'respiratory_rate' => $request->respiratory_rate,
            'pulse_rate' => $request->pulse_rate,
            'cbg' => $request->cbg,
        ]);

        $chart = [
            'past_history' => $past_history,
            'family_history' => $family_history,
            'social_history' => $social_history,
            'patient' => $patient,
            'consultation_history' => $consultation_history,
            'vital_signs' => $vital_signs,
        ];

        return response()->json(['data' => $chart, 'message' => 'Patient Chart Created Successfully.'], 201);
    }
}
