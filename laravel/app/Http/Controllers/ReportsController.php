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

        // Generate columns for csv file
        $columns=
        [
            'project_name' => 'Project Name',
            'total_Score' => 'Total Score',
            'objective_score' => 'Objective Score',
            'subjective_Score' => 'Subjective Score',
            'applicant' => 'Applicant',
            'budget' => 'Budget',
            'notes' => 'Notes',
            'vote_to_fund' => 'Votes to Fund',
            'amount_funded' => 'Amount Funded'
        ];

        $data = [];

        foreach($round->applications as $application)
        {
            $data[] =
            [
                'project_name' => $application->name,
                'total_score' => $application->total_score,
                'objective_score' => $application->objective_score,
                'subjective_Score' => $application->subjective_score,
                'applicant' => $application->user->data->real_name,
                'budget' => $application->budget,
                'notes' => '',
                'vote_to_fund' => '',
                'amount_funded' => ''
            ];

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
