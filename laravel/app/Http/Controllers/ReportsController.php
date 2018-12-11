<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Round;
use App\Models\User;
use App\Models\UserData;
use App\Models\Score;


class ReportsController extends Controller
{
    // Display report page
    public function view()
    {
        $rounds = Round::orderBy('updated_at', 'asc')->get();
        return view('pages/reports/view', compact('rounds'));
    }

    // Generate a new report
    public function generateReport(Request $request)
    {
        $round = Round::find($request->get('round'));

        if(empty($round))
        {
            $request->session()->flash('error', 'A round must be selected to generate reports.');
            return redirect()->back();
        }

        //get all exportable questions
        $exportableQuestions = $round->questions()->where('exportable', true)->get();

        $data = [];

        // Generate columns for csv file
        $columns =
        [
            'project_name' => 'Project Name',
            'total_score' => 'Total Score',
            'objective_score' => 'Objective Score',
            'subjective_Score' => 'Subjective Score',
            'applicant' => 'Applicant',
            'application_link' => 'Application Link',
            'applicant_email'=>'Applicant Email',
            'budget' => 'Budget',
        ];

        //create columns for exportable questions
        foreach ($exportableQuestions as $question)
        {
            $columns['question_' . $question->id] = $question->question;
        }

        //append judge columns
        $columns +=
        [
            'notes' => 'Notes',
            'vote_to_fund' => 'Votes to Fund',
            'amount_funded' => 'Amount Funded'
        ];

        //loop through submitted applications and fill static values
        foreach($round->applications()->where('status', 'submitted')->get() as $application)
        {
            $row =
            [
                'project_name' => $application->name,
                'total_score' => $application->total_score,
                'objective_score' => $application->objective_score,
                'subjective_Score' => $application->subjective_score,
                'applicant' => $application->user->data()->exists() ? $application->user->data->real_name : null,
                'application_link' => url("/applications/{$application->id}/review"),
                'applicant_email'=> $application->user->email,
                'budget' => $application->budget
            ];

            //loop through questions and get the answer for that question
            foreach ($exportableQuestions as $question) {
                $row['question_' . $question->id] = $application->answers()->where('question_id', $question->id)->value('answer');
            }

            //append judge rows
            $row +=
            [
                "notes" => '',
                "three" => '',
                "amount_funded" => ''
            ];

            $data[]=$row;
        }

        $this->generateCSV('Applications Report- ' . date('Y-m-d H:i:s'), $columns, $data);
    }

    private function generateCSV($filename, $columns, $data)
    {
        $filename = $filename . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        $columnNames = array_values($columns);

        $file = fopen('php://output', 'w');
        fputcsv($file, $columnNames);

        foreach($data as $row)
        {
            $output = [];

            foreach($columns as $column => $columnName)
            {
                if(isset($row[$column]))
                {
                    $output[] = $row[$column];
                }
                else
                {
                    $output[] = '';
                }
            }

            fputcsv($file, $output);
        }

        fclose($file);
    }
}
