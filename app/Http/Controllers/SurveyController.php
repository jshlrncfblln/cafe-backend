<?php

namespace App\Http\Controllers;

use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use Illuminate\Http\Request;


class SurveyController extends Controller
{
    //
    public function index()
    {
        $surveys = Survey::with('children')->get(); // Eager load children
        return SurveyResource::collection($surveys);
    }

    public function show($id)
    {
        return Survey::with(['children', 'surveylivelihoods', 'surveyOrganizations', 'surveyChurchPrograms'])->find($id);
    }

    public function create(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'fathers_firstname' => 'required|string',
            'mothers_firstname' => 'required|string',
            'fathers_middlename' => 'required|string',
            'mothers_middlename' => 'required|string',
            'fathers_lastname' => 'required|string',
            'mothers_lastname' => 'required|string',
            'fathers_birthdate' => 'required|date',
            'mothers_birthdate' => 'required|date',
            'fathers_occupation' => 'required|string',
            'mothers_occupation' => 'required|string',
            'address' => 'required|string',
            'fathers_contact_number' => 'nullable|numeric',
            'mothers_contact_number' => 'nullable|numeric',
            'marriage_type' => 'required|string',
            'years_married' => 'nullable|numeric',
            'family_income' => 'nullable|numeric',
        ]);

        // Create the Survey record
        $survey = Survey::create($request->only([
            'fathers_firstname',
            'fathers_middlename',
            'fathers_lastname',
            'mothers_firstname',
            'mothers_middlename',
            'mothers_lastname',
            'fathers_birthdate',
            'mothers_birthdate',
            'fathers_occupation',
            'mothers_occupation',
            'address',
            'fathers_contact_number',
            'mothers_contact_number',
            'marriage_type',
            'years_married',
            'family_income'
        ]));

        // Handle children records
        if (!empty($request->children) && is_array($request->children)) {
            foreach ($request->children as $child) {
                $survey->children()->create([
                    'name' => $child['name'],
                    'birthdate' => $child['birthdate'],
                    'employement_status' => $child['employement_status'],
                    'received' => $child['received'],
                ]);
            }
        }

        // Store organizations, church programs, and livelihood programs if they exist
        $this->storeRelations($survey, $request->organizations, 'surveyOrganizations', 'organization_id');
        $this->storeRelations($survey, $request->church_programs, 'surveyChurchPrograms', 'church_program_id');
        $this->storeRelations($survey, $request->livelihood_programs, 'surveyLivelihoods', 'livelihood_id');

        return $survey;
    }

    private function storeRelations($survey, $data, $relationMethod, $foreignKey)
    {
        // Ensure that $data is an array or null
        $items = $this->ensureArray($data);

        foreach ($items as $item) {
            // Ensure $item is an array when it's not
            if (is_array($item)) {
                // If $item is an array with an 'id' field, use it
                $survey->$relationMethod()->create([$foreignKey => $item['id']]);
            } else {
                // If $item is a simple ID, use it directly
                $survey->$relationMethod()->create([$foreignKey => $item]);
            }
        }
    }
    private function ensureArray($data)
    {
        if (is_null($data)) {
            return []; // Return an empty array if null
        }

        return is_array($data) ? $data : [$data]; // Convert to array if it's not
    }

    public function destroy($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['message' => 'Survey not found'], 404);
        }

        // Delete related children
        $survey->children()->delete();

        // Delete related organizations, church programs, and livelihood programs
        $survey->surveyOrganizations()->delete();
        $survey->surveyChurchPrograms()->delete();
        $survey->surveyLivelihoods()->delete();

        // Finally, delete the survey itself
        $survey->delete();

        return response()->json(['message' => 'Survey and related data deleted successfully']);
    }

    public function getStatistics() {
        $survey = Survey::all();

        $marriageStatus = SurveyResource::getMarriageStatusStatistics($survey);
        $incomeDistribution = SurveyResource::getIncomeDistributionStatistics($survey);

        return response()->json([
            'marriage_status' => $marriageStatus,
            'income_distribution' => $incomeDistribution,
        ]);
    }

}
