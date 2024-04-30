
<p>Hello</p>
<p>Your URL is: <a href="{{ url('/secret/'.$data['url']) }}">{{ url('/secret/'.$data['url']) }}</a></p>
<p>Passphrase : {{ $data['passphrase'] }}</p>
<p>Created at : {{ $data['created_at'] }}</p>