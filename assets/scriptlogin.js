document.getElementById('loginForm').addEventListener('input', function(e) {
          var input = e.target;
          if (input.value.trim() === '') {
            input.classList.remove('is-valid', 'is-invalid');
          } else {
            input.classList.add(input.checkValidity() ? 'is-valid' : 'is-invalid');
          }
        });