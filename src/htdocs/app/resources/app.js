window.onerror = function(msg, url, linenumber) {
  // M.toast({
  //     html: `Error in line number ${linenumber}<br> ${msg} <br> URL: ${url}`
  // });
  return true;
};
function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
var __theme = localStorage.getItem('theme');

function switchTheme() {
  if (__theme == 'light') {
    document.documentElement.setAttribute('data-theme', 'dark');
    localStorage.setItem('theme', 'dark');
    __theme = 'dark';
  } else {
    document.documentElement.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');
    __theme = 'light';
  }
}
if (__theme == 'light') {
  document.documentElement.setAttribute('data-theme', 'light');
  localStorage.setItem('theme', 'light');
} else {
  document.documentElement.setAttribute('data-theme', 'dark');
  localStorage.setItem('theme', 'dark');
}
// history.pushState(null, null, '/app/');
$('.modal').modal();

function todo(id, el) {
  $('#todo_popup').modal('open');
  var __name = el.getElementsByTagName("h5")[0].innerHTML;
  var __priority = el.getElementsByTagName("p")[0].innerHTML;
  var __desc = el.getElementsByTagName("h6")[0].innerHTML;
  document.getElementById('todo_title').innerHTML = __name;
  document.getElementById('todo_desc').innerHTML = nl2br(__desc);
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
$('.collapsible').collapsible({accordion:true});
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
function bug(data, el) {
  $('#todo_popup').modal("open");
  var __name = el.getElementsByTagName("h5")[0].innerHTML;
  var __desc = el.getElementsByTagName("p")[0].innerHTML;
  document.getElementById('todo_title').innerHTML = __name;
  document.getElementById('todo_desc').innerHTML = __desc;
  document.getElementById('todo_priority').innerHTML = '';
}
function change(el, data, project) {
  $('#todo_popup').modal("open");
  var __name = el.getElementsByTagName("h6")[0].innerHTML;
  var __desc = el.getElementsByTagName("p")[0].innerHTML;
  document.getElementById('todo_title').innerHTML = __name;
  document.getElementById('todo_desc').innerHTML = __desc;
  document.getElementById('todo_priority').innerHTML = '<a onclick="document.getElementById(\''+el.id+'\').style.display = \'none\';$(\'#__AJAX_LOADER\').load(\'delete-change.php?id='+ data +'\')" class="btn blue-grey darken-3">Delete</a>';
}
function calendarModal(data, start, end, id) {
  $('#calendarModal').modal('open');
  document.getElementById('calendarModal').getElementsByTagName('h3')[0].innerHTML = data;
  document.getElementById('calendarModal').getElementsByTagName('h6')[0].innerHTML = "Start date: " + start;
  // document.getElementById('calendarModal').getElementsByTagName('h5')[1].innerHTML = "End date: " + end;
  document.getElementById('calendarModalDelete').onclick = function() {$('#__AJAX_LOADER').load('delete-calendar.php?id='+id)}
}
function json(data) {
  return JSON.stringify(data)
}
function join(t, a, s) {
  function format(m) {
    let f = new Intl.DateTimeFormat('en', m);
    return f.format(t);
  }
  return a.map(format).join(s);
}
let a = [{month: 'numeric'}, {day: 'numeric'}, {year: 'numeric'}];
function roadmap(id, name, percent, d1, d2, projectID) {
  $('#roadmapModal').modal('open');
  document.getElementById('mc').innerHTML = `
<form action="edit-roadmap.php" id="roadmapForm" method="POST">
<input type="text" value=${json(name)} id="i1" name="name" style="border:0;font-size: 5vw;height:auto;margin: 30px 0" autofocus autocomplete="off">
<span style="color:gray">Click to edit</span><br><br>
<div><b>Percent complete:</b> <input type="number" name="percent" value=${json(percent)} max="100" style="padding-right: 3px;text-align:right;width:40px;border:0" autofocus autocomplete="off">%</div>
<div><b>Date started:</b> <button type="button" class="btn blue-grey darken-3 right waves-effect waves-light" onclick="this.nextElementSibling.value = join(new Date, a, '/')">Today</button><input name="start" type="text" value=${json(join(d1, a, '/'))} style="width:auto;border:0" autofocus autocomplete="off" id="i2"></div>
<input type="hidden" name="id" value=${json(id)}>
<div><b>Date ended:</b> <button type="button" class="btn blue-grey darken-3 right waves-effect waves-light" onclick="this.nextElementSibling.value = join(new Date, a, '/')">Today</button> <input name="end" id="i3" type="text" value=${json(join(d2, a, '/'))} style="width:auto;border:0" autofocus autocomplete="off"></div>
<a onclick="\$('.modal').modal('close');AJAX_LOAD('delete-roadmap.php?id=${encodeURI(id)}&project=${encodeURI(projectID)}')" class="btn red"><i class="material-icons">delete</i></a>
<button class="btn blue-grey darken-3" type="submit">Save</button>
`;
  $("#roadmapForm").submit(function(e) {
    if (document.getElementById('i1').value == '' || document.getElementById('i1').value == null || document.getElementById('i2').value == '' || document.getElementById('i2').value == null || document.getElementById('i3').value == '' || document.getElementById('i3').value == null) {
      alert('All fields are required');
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
        $('.modal').modal('close')
        AJAX_LOAD('roadmap.php?id='+projectID);
      }
    });
  });
  $('.datepicker').datepicker({
    format: 'mm/dd/yyyy'
  });
}