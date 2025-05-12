<?php
include '../logs/secure.php';
include '../config/config.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    die("⛔ Connexion requise.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = "6LenrjYrAAAAACKPmI5fHnfVHrTcjQAMQUGTvoRz";
    $captchaResponse = $_POST['g-recaptcha-response'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
    $response = json_decode($verify);

    if ($response && $response->success) {
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        if ($email !== $_SESSION['email']) {
            die("⛔ L'email ne correspond pas à celui de la session.");
        }

        require_once '../config/config.php'; 

        try {
            $stmt = $pdo->prepare("INSERT INTO messages (user_id, nom, email, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $nom, $email, $message]);

            // Enregistrer un log des tentatives d'envoi de message
            $logMessage = "[" . date("Y-m-d H:i:s") . "] Message envoyé : Nom = $nom, Email = $email\n";
            file_put_contents('../logs/message_sent.log', $logMessage, FILE_APPEND);

            echo "<h2>✅ Merci $nom, votre message a bien été enregistré.</h2>";
        } catch (PDOException $e) {
            // Enregistrer un log des erreurs d'envoi de message
            $logMessage = "[" . date("Y-m-d H:i:s") . "] Erreur : " . $e->getMessage() . " pour l'email $email\n";
            file_put_contents('../logs/message_error.log', $logMessage, FILE_APPEND);

            echo "<h2>❌ Erreur : " . $e->getMessage() . "</h2>";
        }
    } else {
        echo "<h2>❌ Échec reCAPTCHA. Veuillez réessayer.</h2>";
    }
} else {
    echo "<h2>❌ Accès interdit.</h2>";
}
?>
