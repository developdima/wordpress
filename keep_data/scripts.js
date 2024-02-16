document.addEventListener('DOMContentLoaded', function () {
    /* submit form */
    var form = document.getElementById('form-keepdatas');
    var actionUrl = form.getAttribute('data-action-url');
    var responseDiv = document.getElementById('form-response');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var xhr = new XMLHttpRequest();
        var formData = new FormData(form);
        xhr.open("POST", actionUrl, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                responseDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.send(formData);
    });
    /* ajax */
    var usernameInput = form.querySelector('input[name="username"]');

    usernameInput.addEventListener('blur', function () {
        var authorName = usernameInput.value.trim();

        if (authorName === '') {
            responseDiv.innerHTML = '';
            return;
        }

        var xhr = new XMLHttpRequest();
        var url = keepdatas_ajax.ajaxurl;
        var data = new FormData();
        data.append('action', 'check_author_name');
        data.append('author_name', authorName);
        data.append('nonce', keepdatas_ajax.nonce);

        xhr.open('POST', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                responseDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.send(data);
    });
});