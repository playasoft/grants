<h1>Your application has been submitted!</h1>

<p>
    This email is to confirm that your project "<b>{{ $application->name }}</b>" has been submitted for final review by our judges.
    You may withdraw (and re-submit) your application up until the final deadline.
    Submitting this application does not guarantee that you will recieve funding.
    You may receive additional emails if additional questions are asked in the Q&A period following the grant deadline.
    You will be notified within 30 days of the grant round deadline whether your application is either approved or denied.
</p>

<p>
    To review your submitted application, log into your account on <a href="{{ env('SITE_URL') }} ">{{ env('SITE_NAME') }}</a>.
</p>
<p>
    If you have any questions or need assistance with your application, please email <a href="mailto:grants@apogaea.com" target="_blank">grants@apogaea.com</a>.
</p>
