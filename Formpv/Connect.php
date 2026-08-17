<?php
      $Nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_STRING);
      $Prenom = filter_input(INPUT_POST, 'Prenom', FILTER_SANITIZE_STRING);
      $Pays_ou_tu_vis = filter_input(INPUT_POST, 'Pays', FILTER_SANITIZE_STRING);
      $Ville_ou_Etat = filter_input(INPUT_POST, 'Ville', FILTER_SANITIZE_STRING);
      $Votre_Email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_STRING);
      $Votre_Message = filter_input(INPUT_POST, 'Message', FILTER_SANITIZE_STRING);
	   $Votre_Commentaire = filter_input(INPUT_POST, 'Commentaire', FILTER_SANITIZE_STRING);


      
      $dbNom = "Nom";
      $dbPrenom = "Prenom";
      $dbPays = "Pays";
      $dbVille = "Ville";
      $dbEmail = "Email";
      $dbMessage = "Message";
      $dbComment = "Commentaire";
      

      $conn = new mysqli('localhost', 'root', '', 'real_project' );

      if($conn->connect_error) {
      die('Connect Error(' . $conn->connect_error .') '.$conn->connect_error); 

   }else{
      $stmt = $conn->prepare(" INSERT INTO real_form (Nom, Prenom, Pays, Ville, Email, Message, Commentaire) VALUES (?, ?, ?, ?, ?, ?, ?)");

      if($stmt === false){
      die('Prepare failed: ' . $conn->error);

      }  
        $stmt->bind_param("sssssss", $Nom, $Prenom, $Pays, $Ville, $Email, $Message, $Commentaire);

       if ($stmt->execute()){
       echo "You have succefully Registered";
    } else{
       echo "Error;" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>