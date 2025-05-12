<?php
require_once '../config/config.php';

// Vérifie que la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Enregistrer la tentative de connexion dans le fichier log
    $logMessage = "[" . date("Y-m-d H:i:s") . "] Tentative de connexion : Email = $email, IP = " . $_SERVER['REMOTE_ADDR'] . "\n";
    file_put_contents('../logs/login_attempts.log', $logMessage, FILE_APPEND);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe haché
        if (password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Enregistrer une tentative de connexion réussie dans le log
            $logMessage = "[" . date("Y-m-d H:i:s") . "] Connexion réussie : Email = $email, IP = " . $_SERVER['REMOTE_ADDR'] . "\n";
            file_put_contents('../logs/login_attempts.log', $logMessage, FILE_APPEND);

            // Rediriger vers le formulaire s'il est connecté
            header("Location: ../public/index.php");
            exit();
        } else {
            // Mot de passe incorrect
            echo "Mot de passe incorrect.";

            // Enregistrer une tentative de connexion échouée dans le log
            $logMessage = "[" . date("Y-m-d H:i:s") . "] Connexion échouée : Email = $email, Mot de passe incorrect, IP = " . $_SERVER['REMOTE_ADDR'] . "\n";
            file_put_contents('../logs/login_attempts.log', $logMessage, FILE_APPEND);
        }
    } else {
        // Email introuvable
        echo "Email introuvable.";

        // Enregistrer une tentative de connexion échouée dans le log
        $logMessage = "[" . date("Y-m-d H:i:s") . "] Connexion échouée : Email = $email, Utilisateur non trouvé, IP = " . $_SERVER['REMOTE_ADDR'] . "\n";
        file_put_contents('../logs/login_attempts.log', $logMessage, FILE_APPEND);
    }
} else {
    echo "Requête invalide.";
}
?>
