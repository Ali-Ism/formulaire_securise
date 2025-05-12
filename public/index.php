<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Formulaire de Contact</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    form { max-width: 500px; margin: auto; }
    input, textarea, button {
      width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box;
    }
    .error { color: red; font-size: 0.9em; }
  </style>
</head>
<body>
  <h1>Contactez-nous</h1>
  <form id="contactForm" action="../src/traitement.php" method="POST" onsubmit="return validateForm()">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required />
    <div id="nomError" class="error"></div>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required />
    <div id="emailError" class="error"></div>

    <label for="message">Message :</label>
    <textarea id="message" name="message" rows="5" required></textarea>
    <div id="messageError" class="error"></div>

    <div class="g-recaptcha" data-sitekey="6LenrjYrAAAAAK-CSP20xB_zWKwpuWFhV20WJWvf"></div>
    <div id="captchaError" class="error"></div>

    <button type="submit">Envoyer</button>
  </form>

  <script>
    function validateForm() {
      let valid = true;
      const nom = document.getElementById('nom').value.trim();
      const email = document.getElementById('email').value.trim();
      const message = document.getElementById('message').value.trim();
      const captcha = grecaptcha.getResponse();

      document.getElementById('nomError').textContent = '';
      document.getElementById('emailError').textContent = '';
      document.getElementById('messageError').textContent = '';
      document.getElementById('captchaError').textContent = '';

      if (nom.length < 2) {
        document.getElementById('nomError').textContent = 'Le nom doit contenir au moins 2 caractères.';
        valid = false;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Format d’email invalide.';
        valid = false;
      }

      if (message.length < 10) {
        document.getElementById('messageError').textContent = 'Le message doit contenir au moins 10 caractères.';
        valid = false;
      }

      if (captcha.length === 0) {
        document.getElementById('captchaError').textContent = 'Veuillez valider le reCAPTCHA.';
        valid = false;
      }

      return valid;
    }
  </script>
</body>
</html>
