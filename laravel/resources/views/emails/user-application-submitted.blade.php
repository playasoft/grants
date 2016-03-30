<h1>Your application has been submitted!</h1>

<p>
    This email is to confirm that your project "<b>{{ $application->name }}</b>" has been submitted for final review by our judges.
    Submitting this application does not guarantee that you will recieve funding.
    You may recieve additional emails if additional questions or feedback are requested.
    You will be notified when your application is either approved or denied.
</p>

<p>
    To review your submitted application, log into your account on <a href="{{ env('SITE_URL') }} ">{{ env('SITE_NAME') }}</a>.
</p>
