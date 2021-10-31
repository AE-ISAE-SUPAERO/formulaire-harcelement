anonymous_checkbox = document.getElementById('anonymous');
name_input = document.getElementById('name');
email_input = document.getElementById('email');

anonymous_checkbox.addEventListener('change', update_form);

function update_form(event = null) {
  if (anonymous_checkbox.checked) {
    name_input.disabled = true;
    email_input.disabled = true;
  } else {
    name_input.disabled = false;
    email_input.disabled = false;
  }
}

update_form();

function hide() {
  document.getElementById("intro_button").hidden = true;
}
