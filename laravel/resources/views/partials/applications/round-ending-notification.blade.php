<?php

use Carbon\Carbon;

// Set the end date to 23:59:59
$endDate = Carbon::parse($application->round->end_date);
$endDate->addHours(23)->addMinutes(59)->addSeconds(59);

// Defaults
$class = "alert-warning";
$message = "<b>Notice:</b> There's only %s day%s until the current grant round ends.";
$value = $endDate->diffInDays(Carbon::now());
$plural = "s";

// Conditions to override defaults
if($endDate->diffInHours(Carbon::now()) < 1)
{
    $class = "alert-danger";
    $message = "<b>RED ALERT!</b> There's only %s minute%s until the current grant round ends.";
    $value = $endDate->diffInMinutes(Carbon::now()); 
}
elseif($endDate->diffInDays(Carbon::now()) < 1)
{
    $class = "alert-danger";
    $message = "<b>Warning:</b> There's only %s hour%s until the current grant round ends.";
    $value = $endDate->diffInHours(Carbon::now());
}

// Different messages based on the application status
if($application->status == "submitted")
{
    $message .= " You can withdraw your application to make changes, but make sure to re-submit it after!";
}
else
{
    $message .= " Make sure your application is submitted soon!";
}

// Proper grammar is important
if($value == 1)
{
    $plural = "";
}

$message = sprintf($message, $value, $plural);

?>

@if($application->round->status() == "ongoing" && $endDate->diffInDays(Carbon::now()) <= 7)
    <div class="general-alert alert {{ $class }}" role="alert">
        {!! $message !!}
    </div>
@endif
