<?php

// Connexion à la base de données
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement du formulaire de candidature
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $id_chercheur = $_POST['id_chercheur']; // Récupérer l'ID du chercheur à partir du champ caché
    $offre_id = $_POST['offre_id']; // Récupérer l'ID de l'offre sélectionnée

    // Vérifier si l'ID du chercheur existe dans la table chercheuremploi
    $sql_check = "SELECT ID_chercheur FROM chercheuremploi WHERE ID_chercheur = '$id_chercheur'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Vérifier si un fichier a été téléchargé
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
            // Définir le chemin de destination complet pour le fichier CV
            $destination = 'C:/xampp/htdocs/pfa/cv_doss/';

            // Vérifiez si le répertoire existe, sinon créez-le
            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }

            // Générer un nom unique pour le fichier CV
            $cv_name = uniqid('cv_') . '.pdf';

            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $destination . $cv_name)) {
                // Insérer l'URL du CV dans la table cv
                $cv_url = 'pfa/cv_doss/' . $cv_name;
                $sql_cv = "INSERT INTO cv (ID_chercheur, URL_cv) VALUES ('$id_chercheur', '$cv_url')";
                if ($conn->query($sql_cv) === TRUE) {
                    echo "CV inséré avec succès.";
                } else {
                    echo "Erreur lors de l'insertion du CV : " . $conn->error;
                }

                // Insérer la candidature dans la table candidature
                $sql_candidature = "INSERT INTO candidature (ID_chercheur, ID_offre, Statut, Date_soumission) VALUES ('$id_chercheur', '$offre_id', 'En attente', NOW())";
                if ($conn->query($sql_candidature) === TRUE) {
                    echo "Candidature insérée avec succès.";
                } else {
                    echo "Erreur lors de l'insertion de la candidature : " . $conn->error;
                }
            } else {
                echo "Une erreur s'est produite lors du téléchargement du CV.";
            }
        } else {
            echo "Veuillez télécharger votre CV.";
        }
    } else {
        echo "Erreur : ID du chercheur non trouvé.";
    }
}
?>
