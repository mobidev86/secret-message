<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Secret</title>
    <!-- Include CSRF token in meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- In the <head> section -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container py-5 urlgen_form">
        <h1>Create Secret 🤫</h1>
        <div class="row g-4">
            <div class="alert alert-danger alert-dismissible fade show" id="invalid-code" style="display:none">
                <strong>Oops!</strong> Please fill the data. 😐
            </div>
            <div class="alert alert-danger alert-dismissible fade show" id="email-error" style="display:none">
                Please enter valid email. 😶
            </div>
            <div class="col-12">
                <textarea id="content" class="form-control" rows="5" placeholder="Secret content goes here..."></textarea>
            </div>
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="control-label lighter" for="passphrase">Passphrase:</label>
                        <input id="passphrase" type="text" class="form-control" placeholder="A word or phrase that's difficult to guess">
                    </div>
                     <div class="col-12 col-md-4">
                        <label class="control-label lighter" for="email">Email:</label>
                        <input id="email" type="email" class="form-control" placeholder="Enter your email here">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="control-label lighter" for="lifetime">Lifetime:</label>
                        <select id="lifetime" class="form-select">
                            <option value="604800">7 days</option>
                            <option value="259200">3 days</option>
                            <option value="86400">1 day</option>
                            <option value="43200">12 hours</option>
                            <option value="14400">4 hours</option>
                            <option value="3600">1 hour</option>
                            <option value="1800">30 minutes</option>
                            <option value="300">5 minutes</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <button id="createSecret" class="btn btn-primary custom-btn" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Creating secret link">Create a secret link</button>
                </div>
                <!-- Textarea to display the created URL -->
                 <div class="row g-3" id="data-found" style="display:none">
                    <div class="col-12">
                        <label class="control-label lighter mb-2" for="url">Generated URL: 😃</label>
                        <textarea id="secretUrl" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script> var baseSecretUrl = "{{ url('/secret/') }}"; </script>
    <script src="{{ asset('js/create_secret.js') }}"></script>
</body>
</html>
