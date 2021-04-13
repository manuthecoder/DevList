window.onerror = function(msg, url, linenumber) {
    M.toast({
        html: `Error in line number ${linenumber}<br> ${msg} <br> URL: ${url}`
    });
    return true;
}
var __theme = localStorage.getItem('theme');

function switchTheme() {
    if (__theme == 'light') {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        __theme = 'dark'
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
        __theme = 'light'
    }
}
if (__theme == 'light') {
    document.documentElement.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');
} else {
    document.documentElement.setAttribute('data-theme', 'dark');
    localStorage.setItem('theme', 'dark');
}
history.pushState(null, null, '/app/');
$('.modal').modal();

function todo(id, el) {
    $('#todo_popup').modal('open');
    var __name = el.getElementsByTagName("h5")[0].innerHTML;
    var __priority = el.getElementsByTagName("p")[0].innerHTML;
    var __desc = el.getElementsByTagName("h6")[0].innerHTML;
    document.getElementById('todo_title').innerHTML = __name;
    document.getElementById('todo_desc').innerHTML = __desc;
    document.getElementById('todo_priority').innerHTML = __priority;
}
$('#slide-out').sidenav();

function AJAX_LOAD(data) {
    document.getElementById('__ajaxLoader').innerHTML = `<div class="loader">
<svg viewBox="0 0 32 32" width="42" height="42">
<circle id="spinner" cx="16" cy="16" r="14" fill="none"></circle>
</svg>
</div>`;
    $('#__ajaxLoader').load(data)
}
$('.collapsible').collapsible();
$("#__avatarForm").submit(function(e) {
    if (document.getElementById('avatar_url').value == '' || document.getElementById('avatar_url').value == null) {
        document.getElementById('avatar__banner').style.display = 'none';
        document.getElementById('avatar_err__banner').style.display = 'none';
        document.getElementById('avatar_err__banner').style.display = 'block';
        return false;
    }
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            document.getElementById('avatar_err__banner').style.display = 'none';
            document.getElementById('avatar__banner').style.display = 'block';
        }
    });
});
$("#__emailForm").submit(function(e) {
    if (document.getElementById('user_change_email_address').value == '' || document.getElementById('user_change_email_address').value == null) {
        document.getElementById('email__banner').style.display = 'none';
        document.getElementById('email_err__banner').style.display = 'none';
        document.getElementById('email_err__banner').style.display = 'block';
        return false;
    }
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            document.getElementById('email_err__banner').style.display = 'none';
            document.getElementById('email__banner').style.display = 'block';
        }
    });
});
window.addEventListener('load', function() {
    AJAX_LOAD('home.php');
});
var form = document.getElementById("my-form");

async function handleSubmit(event) {
    event.preventDefault();
    var status = document.getElementById("my-form-status");
    var data = new FormData(event.target);
    fetch(event.target.action, {
    method: form.method,
    body: data,
    headers: {
        'Accept': 'application/json'
    }
    }).then(response => {
    status.style.display = 'block';
    form.reset()
    }).catch(error => {
    status.innerHTML = "Oops! There was a problem submitting your form"
    });
}
form.addEventListener("submit", handleSubmit)