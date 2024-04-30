<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secret Message</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body>

@if(strtotime($secret->expires_at) < strtotime(now()))
<div class="urlgen_form_message">
    This secret has expired. ⌛️
</div>
@elseif($secret->is_read == true)
    <div class="urlgen_form_message">
        Message is already read 🙊
    </div>
@else
  <div class="container py-5 urlgen_form">
        <h1>Secret Message 🤫</h1>
            <div id="form-submit">
                <div class="mb-3">
                    <label for="passphrase" class="form-label">Enter Passphrase:</label>
                    <input type="password" class="form-control" id="passphrase" name="passphrase" required>
                </div>
                 <div class="alert alert-danger alert-dismissible fade show" id="invalid-code" style="display:none">
                    <strong>Oops!</strong> Double check that passphrase. 😐
                </div>
                
                <button type="button" id="checkPassphrase" class="btn btn-primary custom-btn" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading...">Unlock Message</button>
            </div>

            <div class="col mt-3" id="data-found" style="display:none">
                 <label class="control-label lighter mb-2" for="data-found">This message is for you: 😀</label>
                    <textarea id="data-show" class="form-control" rows="2" readonly></textarea>
            </div>
        @if(session('message'))
            <div class="alert alert-danger mt-3">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endif
<script> var baseSecretUrl = "{{ $secret->url }}"; </script>
<script src="{{ asset('js/create_secret.js') }}"></script>
</body>
</html>
