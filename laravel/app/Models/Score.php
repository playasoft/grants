<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['score', 'answer'];

    // Scores belong to an application
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    // Scores belong to criteria
    public function criteria()
    {
        return $this->belongsTo('App\Models\Criteria');
    }

    // Scores are set by a specific user (judges)
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function calculateTotals($application)
    {
        // Select scores for the current application that have been finalized (appear in the judged table)
        $scores = Score::where('scores.application_id', $application->id)->join('judged', function($join)
        {
            $join->on('judged.user_id', '=', 'scores.user_id')->on('judged.application_id', '=', 'scores.application_id');
        })->get();

        $objective = 0;
        $subjective = 0;
        $total = 0;

        foreach($scores as $score)
        {
            if($score->criteria->type == 'objective')
            {
                if ((int)$score->score) // If Yes or No
                {
                    $objective += (int)$score->score;
                }
                else // If criteria score is NA, 0, Add 1 (YES) to question's objective score.
                {
                    $objective += 1;
                }
            }
            else
            {
                $subjective += (int)$score->score;
            }

            $total += (int)$score->score;
        }

        $application->objective_score = $objective;
        $application->subjective_score = $subjective;
        $application->total_score = $total;
        $application->save();

        return compact('objective', 'subjective', 'total');
    }
}
