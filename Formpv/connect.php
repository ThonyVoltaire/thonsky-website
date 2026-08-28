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
<?php
// 1. Récupération et sécurisation moderne des données (sans FILTER_SANITIZE_STRING qui est obsolète)
$Nom = isset($_POST['Nom']) ? htmlspecialchars(trim($_POST['Nom'])) : '';
$Prenom = isset($_POST['Prenom']) ? htmlspecialchars(trim($_POST['Prenom'])) : '';
$Pays = isset($_POST['Pays']) ? htmlspecialchars(trim($_POST['Pays'])) : '';
$Ville = isset($_POST['Ville']) ? htmlspecialchars(trim($_POST['Ville'])) : '';
$Email = isset($_POST['Email']) ? filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL) : '';

// Ici, on récupère 'sujet' car c'est le nom exact écrit dans votre fichier HTML (<select name="sujet">)
$Message = isset($_POST['sujet']) ? htmlspecialchars(trim($_POST['sujet'])) : '';
$Commentaire = isset($_POST['Commentaire']) ? htmlspecialchars(trim($_POST['Commentaire'])) : '';

// 2. Connexion à votre base locale XAMPP
$conn = new mysqli('localhost', 'root', '', 'real_project');

// Vérification de la connexion
if ($conn->connect_error) {
    die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error); 
}

// 3. Préparation de la requête SQL d'insertion
$stmt = $conn->prepare("INSERT INTO real_form (Nom, Prenom, Pays, Ville, Email, Message, Commentaire) VALUES (?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die('Échec de la préparation SQL (Vérifiez bien le nom de vos colonnes dans PHPMyAdmin) : ' . $conn->error);
}  

// 4. Liaison des paramètres avec les bonnes variables correspondantes
$stmt->bind_param("sssssss", $Nom, $Prenom, $Pays, $Ville, $Email, $Message, $Commentaire);

// 5. Exécution et message de confirmation
if ($stmt->execute()) {
    echo "<div style='background: #28a745; color: white; padding: 25px; text-align: center; font-family: sans-serif; font-size: 1.3rem; border-radius: 8px; margin: 50px auto; max-width: 600px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);'>
            🎉 <strong>Enregistrement réussi !</strong><br><br>
            Mèsi! Done ou yo sove avèk siksè nan baz de done a.
          </div>";
    
    // Redirection automatique vers votre page d'accueil après 3 secondes
    header("refresh:3;url=../index.html");
} else {
    echo "<div style='background: #dc3545; color: white; padding: 25px; text-align: center; font-family: sans-serif; border-radius: 8px; margin: 50px auto; max-width: 600px;'>
            ❌ <strong>Erreur lors de l'enregistrement :</strong> " . $stmt->error . "
          </div>";
}

// 6. Fermeture des connexions
$stmt->close();
$conn->close();
?>