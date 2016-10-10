<!--

  Code php pour le rafraichissement de la page automatique
  associés au script php de la page index.php


  Info bdd
  base de données avec 1 table : minichat
  minichat 3 colonnes : id (int,AI,PRIMARY), pseudo(varchar(255)), message(varchar(255)).

 -->


<?php
// Conection a la base de donnée

try
{
   $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'simplon');
}
catch(Exception $e)
{
   die('Erreur : '.$e->getMessage());
}

  // Récupération des 10 derniers messages
  $reponse = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 0, 10');

  // Boucle d'affichage des messages PSEUDO :message
  while ($msg = $reponse->fetch()) {
         ?>

      <div id="refresh" class="containermsg">
        <b><?php echo $msg['pseudo']; ?>:</b> <?php echo $msg['message']; ?> <br>
      </div>

    <?php
  }

  ?>
