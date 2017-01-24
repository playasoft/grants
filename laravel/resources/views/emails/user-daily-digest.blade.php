<h1>Some questions about your applicaiton</h1>

<p>
    Thank you for submitting your application to <b>{{ env('SITE_NAME') }}</b>.
    Our judges have reviewed your application and need to know some more information.
</p>

@foreach($applications as $application)
    <p>
        Regarding your application "<b>{{ $application['application']->name }}</b>":
    </p>

    <ul>
        @foreach($application['feedback'] as $feedback)
            @if(empty($feedback->response))
                <li>{{ $feedback->message }}</li>
            @endif
        @endforeach
    </ul>
@endforeach

<p>
    In order to answer these questions, please <a href="{{ env('SITE_URL') }}">log into your account</a> and review your application.
</p>
