<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require 'config.php';

$message_empty = false;
$reply_to_error = false;
$email_status = false;
$email_error = false;

// IF MESSAGE, PROCESS AND SEND
if (array_key_exists('message', $_POST)) {
  if (empty(trim($_POST['message']))) {
    $message_empty = true;
  } else {
    // gather information from post variables
    if (array_key_exists('anonymous', $_POST)) {
      $anonymous = filter_var($_POST['anonymous'], FILTER_VALIDATE_BOOLEAN);
    } else {
      $anonymous = false;
    }

    $name = '';
    $subject = '[ae-isae-supaero.fr] Témoignage harcèlement anonyme';
    if (!$anonymous) {
      if (array_key_exists('name', $_POST)) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
          $subject = '[ae-isae-supaero.fr] Témoignage harcèlement de ' . $name;
        }
      }
    }

    if (array_key_exists('email', $_POST)) {
      $reply_to = $_POST['email'];
      if (!empty($reply_to) && !PHPMailer::validateAddress($reply_to)) {
        $reply_to = '';
        $reply_to_error = true;
      }
    } else {
      $reply_to = '';
    }

    // send email
    if (!$reply_to_error) {
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->CharSet = PHPMailer::CHARSET_UTF8;
      $mail->Host = $host;
      $mail->Port = $port;
      $mail->SMTPAuth = true;
      $mail->Username = $from;
      $mail->Password = $pwd;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

      $mail->setFrom($from);
      foreach($to as $address)
      $mail->addAddress($address);
      if (!empty($reply_to))
        $mail->addReplyTo($reply_to);
      $mail->Subject = $subject;
      $mail->isHTML(false);
      $mail->Body = $_POST['message'];

      $email_status = true;
      if (!$mail->send()) {
        $email_error = true;
      }
    }
  }
}
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AE ISAE-SUPAERO - Témoignages harcèlement</title>
  <link rel="icon" type="image/png" href="/favicon.ico">

  <style>
    * {
      --bs-bg-opacity: .9 !important;
    }
  </style>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <div class="m-3 mx-md-5">
    <div class="mb-4">
      <h1>Formulaire témoignages harcèlement</h1>
      <h5>AE ISAE-SUPAERO - Pôle HDVS</h5>
    </div>

    <div class="p-3 mb-2 bg-success text-white rounded" <?php if (!$email_status || $email_error) echo 'hidden'; ?>>Email envoyé, merci de votre témoignage.</div>
    <div class="p-3 mb-2 bg-warning text-white rounded" <?php if (!$message_empty) echo 'hidden'; ?>>Message vide ! Veuillez réessayer...</div>
    <div class="p-3 mb-2 bg-warning text-white rounded" <?php if (!$reply_to_error) echo 'hidden'; ?>>Format de l'email erroné ! Veuillez réessayer...</div>
    <div class="p-3 mb-2 bg-danger text-white rounded" <?php if (!($email_status && $email_error)) echo 'hidden'; ?>>Erreur d'envoi ! Veuillez réessayer...</div>

    <div class="p-3 mb-4 border rounded shadow-sm">
      <form method="POST">
        <div class="form-group">
          <input type="checkbox" class="form-check-input" name="anonymous" id="anonymous" <?php if (array_key_exists('anonymous', $_POST) && $_POST['anonymous']) echo 'checked'; ?>>
          <label for="anonymous">Anonyme</label>
        </div>
        <br>
        <div class="form-group">
          <label for="text">Nom :</label>
          <input type="text" class="form-control" name="name" id="name" <?php if (array_key_exists('name', $_POST)) {
                                                                          echo ('value="' . $_POST['name'] . '"');
                                                                        } ?>>
        </div>
        <br>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="text" class="form-control" name="email" id="email" <?php if (array_key_exists('email', $_POST)) {
                                                                              echo ('value="' . $_POST['email'] . '"');
                                                                            } ?>>
        </div>
        <br>
        <div class="form-group">
          <label for="message">Votre Témoignage :</label>
          <textarea name="message" class="form-control" id="message" rows="10"><?php if (array_key_exists('message', $_POST)) {
                                                                                  echo ($_POST['message']);
                                                                                } ?></textarea>
        </div>
        <br>
        <input type="submit" class="btn btn-primary" value="Envoyer">
      </form>
    </div>

    <p class="text-center lh-sm text-muted">
      <small>
        Les informations remplies ici sont exclusivement envoyées au responsable du pôle HDVS, Carl Guignon.<br>
        Que « Anonyme » soit coché ou non, ce site n'enregistre rien sur vous ou votre message.<br><br>
        Si vous ne me croyez pas, vous pouvez vérifier dans le code source en cliquant <a href="https://github.com/ae-isae-supaero/formulaire-harcelement" target="_blank">ici</a>.<br><br>
        © 2021 AE ISAE-SUPAERO / Victor Colomb - <a class="text-reset" href="https://github.com/ae-isae-supaero/formulaire-harcelement/blob/main/LICENSE" target="_blank">MIT License</a>
      </small>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="index.js"></script>
</body>

</html>