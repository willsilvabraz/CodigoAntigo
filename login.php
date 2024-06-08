<?php
session_start();
require __dir__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $usuarios = $database->getReference('usuarios')->orderByChild('email')->equalTo($email)->getValue();
    
    if ($usuarios) {
        foreach ($usuarios as $usuario) {
            if ($usuario['senha'] === $senha) {
                $_SESSION['cargo'] = $usuario['cargo'];
                echo '<script> alert("Login bem-sucedido!");  window.location.href = "layout.php";</script>';
            }
        }
    }
    
    echo "Email ou senha incorretos!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <div class="container">
      <div class="form-image">
        <img src="/img/login.svg" />
      </div>
      <div class="form">
        <form method="post">
          <div class="form-header">
            <div class="title">
              <h1>Login</h1>
            </div>
          </div>
  
          <div class="input-group">
            <div class="input-box">
              <div><label for="email">E-mail</label></div>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
              />
            </div>
  
            <div class="input-box">
              <div><label for="senha">Senha</label></div>
              <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite sua senha.."
                required
              />
            </div>
          </div>
  
          <div class="continue-button">
            <button type="submit" id="enviar">
              Entrar
            </button>
          </div>
          <br />
        </form>
      </div>
    </div>
  </body>
</html>
