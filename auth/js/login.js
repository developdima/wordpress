document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('loginForm');
    form.onsubmit = function(e) {
        e.preventDefault();
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/login/login.php', true);
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                if (response.success) {
                    window.location.href = '/';
                } else {
                    alert(response.message);
                }
            }
        };
        xhr.send(formData);
    };
});
