if (document.getElementById('createSecret')) {
    document.getElementById('createSecret').addEventListener('click', function() {
        var originalText = this.innerHTML;
        this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Creating secret link';
        this.disabled = true;

        var content = document.getElementById('content').value;
        var passphrase = document.getElementById('passphrase').value;
        var lifetime = document.getElementById('lifetime').value;
        var email = document.getElementById('email').value;
        
        var data = {
            content: content,
            passphrase: passphrase,
            lifetime: lifetime,
            email: email
        };

        // Email validation
        if (email && !validateEmail(email)) {
            document.getElementById('email-error').style.display = 'block'; 
            this.innerHTML = originalText;
            this.disabled = false;
            return; // Stop further execution
        } else {
            document.getElementById('email-error').style.display = 'none'; 
        }


        // Check if any of the required fields is empty
        if (!content || !passphrase || !lifetime) {
            this.innerHTML = originalText;
            this.disabled = false;
            document.getElementById('invalid-code').style.display = 'block';
            return; // Stop further execution
        }
        fetch('/store-secret', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Include CSRF token in the request headers
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error creating secret');
            }
        })
        .then(data => {
            var fullUrl = baseSecretUrl + '/' + data.url;
            // Display the created URL in the textarea
            document.getElementById('secretUrl').value = fullUrl;
            document.getElementById('passphrase').value = '';
            document.getElementById('email').value = '';
            document.getElementById('content').value = '';
            document.getElementById('data-found').style.display = 'block';
            this.innerHTML = originalText;
            this.disabled = false;
        })
        .catch(error => {
            this.innerHTML = originalText;
            this.disabled = false;
            console.error('Error:', error);
            alert(error.message);
        });
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    });
}

if (document.getElementById('checkPassphrase')) {
    document.getElementById('checkPassphrase').addEventListener('click', function() {
            
        var originalText = this.innerHTML;
        this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
        this.disabled = true;

        var passphrase = document.getElementById('passphrase').value;
        var data = {
            passphrase: passphrase,
        };

        fetch('/secret/'+baseSecretUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                // Include CSRF token in the request headers
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            document.getElementById('invalid-code').style.display = 'none';
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error creating secret');
            }
        })
        .then(data => {
            this.innerHTML = originalText;
            this.disabled = false;

            if(data.status == false){
                document.getElementById('invalid-code').style.display = 'block';
            }

            if(data.status == true){
                document.getElementById('data-show').value = data.data.content;
                document.getElementById('data-found').style.display = 'block';
                document.getElementById('form-submit').style.display = 'none';
            }
        })
        .catch(error => {
            this.innerHTML = originalText;
            this.disabled = false;
            console.error('Error:', error);
            alert(error.message);
        });
    });
}