<?php

// email to
$to = ['carl.guignon@student.isae-supaero.fr'];
// email to names (displayed in the information footer)
$names = ['Carl Guignon'];

// email server settings
$host = 'mail44.lwspanel.com';
$port = 465;
$from = 'EMAIL_PLACEHOLDER';   // replaced during GitHub action
$pwd = 'PASSWORD_PLACEHOLDER'; // same

// accepted languages (see what is available in assets/lang/)
// first is default
$accepted_languages = [
  'fr' => 'Français',
  'en' => 'English'
];

// uploads
$target_dir = './uploads';
$max_attachement_size = 2.5e7;

?>
