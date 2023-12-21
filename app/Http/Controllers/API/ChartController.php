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


class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
            'heart_disease'  => $request->heart_disease,
            'dm'  => $request->dm,
            'previous_or' => strtoupper($request->previous_or),
            'previous_hospitalization' => strtoupper($request->previous_or),
            'other_findings' => strtoupper($request->previous_or),
        ]);

        $family_history = FamilyHistory::create([
            'unremarkable' => $request->f_unremarkable,
            'hcvd' => $request->hcvd,
            'chd' => $request->chd,
            'cva' => $request->f_cva,
            'gut_disease' => $request->f_gut_disease,
            'blood_dyscrasia' => $request->blood_dyscrasia,
            'allergy' => $request->allergy,
            'dm' => $request->f_dm,
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

        $consultationNo = ConsultationHistory::generateConsultationNo();

        $consultation_history = ConsultationHistory::create([
            'patient_id' => $patient->id,
            'physician_id' => $request->physician_id,
            'consultation_no' => $consultationNo,
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
            'temperature' => $request->temperature,
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

    public function updatePastHistory(Request $request, $id)
    {
        $past_history = PastHistory::findOrFail($id)->update([
            'unremarkable' => $request->unremarkable,
            'blood_disease' => $request->blood_disease,
            'asthma' => $request->asthma,
            'hypertension' => $request->hypertension,
            'cva' => $request->cva,
            'gut_disease' => $request->gut_disease,
            'git_disease' => $request->git_disease,
            'pulmo_disease' => $request->pulmo_disease,
            'heart_disease'  => $request->heart_disease,
            'dm'  => $request->dm,
            'previous_or' => strtoupper($request->previous_or),
            'previous_hospitalization' => strtoupper($request->previous_or),
            'other_findings' => strtoupper($request->previous_or),
        ]);

        return response()->json(['data' => $past_history, 'message' => 'Past History Record Updated Successfully.'], 200);
    }

    public function updateFamilyHistory(Request $request, $id)
    {
        $family_history = FamilyHistory::findOrFail($id)->update([
            'unremarkable' => $request->f_unremarkable,
            'hcvd' => $request->hcvd,
            'chd' => $request->chd,
            'cva' => $request->f_cva,
            'gut_disease' => $request->f_gut_disease,
            'blood_dyscrasia' => $request->blood_dyscrasia,
            'allergy' => $request->allergy,
            'dm' => $request->f_dm,
            'git_disease' => $request->f_git_disease,
            'pulmo_disease' => $request->f_pulmo_disease,
            'ca' => $request->ca,
            'other_findings' => strtoupper($request->f_other_findings),
        ]);

        return response()->json(['data' => $family_history, 'message' => 'Family History Record Updated Successfully'], 200);
    }

    public function updateSocialHistory(Request $request, $id)
    {
        $social_history = SocialHistory::findOrFail($id)->update([
            'smoking' => strtoupper($request->smoking),
            'alcohol_intake' => strtoupper($request->alcohol_intake),
            'betel_nut_chewing' => strtoupper($request->betel_nut_chewing),
            'drug_food_allergy' => strtoupper($request->drug_food_allergy),
            'others' => strtoupper($request->others),
        ]);

        return response()->json(['data' => $social_history, 'message' => 'Social History Record Updated Successfully'], 200);
    }

    public function updatePatient(Request $request, $id)
    {
        $patient = Patient::findOrFail($id)->update([
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'gender' => $request->gender,
            'contact_no' => $request->contact_no,
            'address' => strtoupper($request->address),
            'vaccination' => strtoupper($request->vaccination),
            'created_by' => $request->created_by,
        ]);

        return response()->json(['data' => $patient, 'message' => 'Patient Information Record Updated Successfully'], 200);
    }

    public function updateConsultation(Request $request, $id)
    {
        $consultation_history = ConsultationHistory::findOrFail($id)->update([
            'physician_id' => $request->physician_id,
            'consultation_datetime' => $request->consultation_datetime,
            'payment_type' => $request->payment_type,
            'chief_complaint' => strtoupper($request->chief_complaint),
            'subjective' => strtoupper($request->subjective),
            'objective' => strtoupper($request->objective),
            'assessment' => strtoupper($request->assessment),
            'plan' => strtoupper($request->plan),
            'created_by' => $request->created_by,
        ]);

        return response()->json(['data' => $consultation_history, 'message' => 'Consultation History Record Updated Successfully'], 200);
    }

    public function updateVitalSigns(Request $request, $id)
    {
        $vital_signs = VitalSigns::findOrFail($id)->update([
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $request->bmi,
            'bp_f' => $request->bp_f,
            'bp_s' => $request->bp_s,
            'oxygen_saturation' => $request->oxygen_saturation,
            'temperature' => $request->temperature,
            'respiratory_rate' => $request->respiratory_rate,
            'pulse_rate' => $request->pulse_rate,
            'cbg' => $request->cbg,
        ]);

        return response()->json(['data' => $vital_signs, 'message' => 'Vital Signs Record Updated Successfully'], 200);
    }

    public function createExistingPatient(Request $request, $id)
    {
        $consultationNo = ConsultationHistory::generateConsultationNo();
        $consultation_history = ConsultationHistory::create([
            'patient_id' => $request->patient_id,
            'physician_id' => $request->physician_id,
            'consultation_no' => $consultationNo,
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
            'temperature' => $request->temperature,
            'respiratory_rate' => $request->respiratory_rate,
            'pulse_rate' => $request->pulse_rate,
            'cbg' => $request->cbg,
        ]);

        $chart = [
            'consultation_history' => $consultation_history,
            'vital_signs' => $vital_signs,
        ];

        return response()->json(['data' => $chart, 'message' => 'Consultation Created Successfully'], 201);
    }

    public function getPast($id)
    {
        $past_history = PastHistory::findOrFail($id);
        return response()->json(['data' => $past_history, 'message' => 'Past History Record Retrieved'], 200);
    }

    public function getFamily($id)
    {
        $family_history = FamilyHistory::findOrFail($id);
        return response()->json(['data' => $family_history, 'message' => 'Family History Record Retrieved'], 200);
    }

    public function getSocial($id)
    {
        $social_history = SocialHistory::findOrFail($id);
        return response()->json(['data' => $social_history, 'message' => 'Social History Record Retrieved'], 200);
    }

    public function getPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json(['data' => $patient, 'message' => 'Patient Record Retrieved'], 200);
    }

    public function getConsultationHistory($id)
    {
        $consultation_history = ConsultationHistory::findOrFail($id);
        return response()->json(['data' => $consultation_history, 'message' => 'Consultation History Record Retrieved'], 200);
    }

    public function getVitalSigns($id)
    {
        $vital_signs = VitalSigns::findOrFail($id);
        return response()->json(['data' => $vital_signs, 'message' => 'Vital Signs Record Retrieved'], 200);
    }
}
