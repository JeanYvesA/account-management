<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Bonjour {{$user->firstname}},</h2>
    <p>Votre code d'activation est :</p> <br>
    <strong>{{$user->activation_code}}</strong>
    <p>Cordialement,</p>
    <p>Account Management</p>
  </body>
</html>