# AE ISAE-SUPAERO HDVS Anonymous Mail

## 🌍 Context

> HDVS stands for Harassment, Discrimination, Sexual and sexist Violence  
> In French : Harcèlement, Discriminations, Violences Sexistes et sexuelles

This simple webapp allows ISAE-SUPAERO students to report past HDVS incidents anonymously or not.

It is easily adaptable for many other contexts, to allow users to send anonymous reports.

## 🧩 Configuration

Configuration is possible in the `config.php` file :

* Languages can be added
* Recipients' names and emails can be modified
* Email server details can be setup (the server email and password are hidden from the public code for obvious reasons)

## ⚙️ Components

Reports are sent by email to a very limited number of people.  
This repo works with [PHPMailer](https://github.com/PHPMailer/PHPMailer) to send signed emails.

The webapp is translated in both French and English. It will look for the previously used language (set in a cookie), match your browser's accepted languages or default to French.

If the "Anonymous" checkbox is ticked, nothing that can identify the sender will be sent. Whatever the user chooses, nothing will ever be recorded on the server - only the recipients will receive the report.

The form includes a CSRF token check.

## ⚖️ License

This repo is licensed under the [MIT license](https://github.com/AE-ISAE-SUPAERO/messagerie-hdvs/blob/main/LICENSE).
Feel free to use and adapt this code.
