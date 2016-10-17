<!--

  Info bdd
  base de données avec 1 table : minichat
  minichat 3 colonnes : id (int,AI,PRIMARY), pseudo(varchar(255)), message(varchar(255)).

-->


<?php
// Conection a la base de donnée

try
{
   $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', '');
}
catch(Exception $e)
{
   die('Erreur : '.$e->getMessage());
}

// s'assurrer que les champs sont remplis
if(isset($_POST['pseudo']) AND isset($_POST['message']) AND !empty($_POST['pseudo']) AND !empty($_POST['message']))
{
  // creation des variables pour fail xss et rappel de la BDD sur la meme page
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $message = htmlspecialchars($_POST['message']);
  $insertmsg = $bdd->prepare('INSERT INTO minichat(pseudo, message) VALUES(?, ?)');
  $insertmsg->execute(array($pseudo, $message));
}

 ?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Minichat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
  </head>
  <body>
    <h1>Bienvenue sur le Minichat Simplon</h1>
    <!-- Formulaire minichat -->
    <form class="container" action="" method="post">
      <input type="text" placeholder="Pseudo" name="pseudo" value=""><br>
      <textarea rows="15" cols="40" type="text" name="message" value="" placeholder="Votre message"></textarea><br>
      <input  type="submit" name="name" value="envoyer" class="button">
    </form>
    <div id="messages">

    <?php
      // Récupération des 10 derniers messages
      $reponse = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 0, 10');

      // Boucle d'affichage des message PSEUDO :message
      while ($msg = $reponse->fetch()) {
             ?>

          <div id="refresh" class="containermsg">
            <b><?php echo $msg['pseudo']; ?>:</b> <?php echo $msg['message']; ?> <br>
          </div>

        <?php
      }

      ?>
    </div>

<!-- Script pour rafraichissement de la page automatique ! -->
      <script>
        setInterval('load_messages()', 500);
        function load_messages(){
          $('#messages').load('load_messages.php');
        }

      </script>
  </body>
</html>
