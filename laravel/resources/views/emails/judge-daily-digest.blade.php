<h1>Weightlifter Daily Digest</h1>

@foreach($applications as $application)
    <p>
        Regarding application "<b><a href="{{ env('SITE_URL') }}/applications/{{ $application['application']->id }}/review">{{ $application['application']->name }}</a></b>":
    </p>

    <ul>
        @foreach($application['feedback'] as $feedback)
            <li>
                <b>Question asked:</b> {{ $feedback->message }}

                @if(!empty($feedback->response))
                    <br>
                    <b>User responed:</b> {{ $feedback->response }}
                @endif
            </li>
        @endforeach
    </ul>
@endforeach
