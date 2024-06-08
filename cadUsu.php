<?php

require __dir__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

// Verifique se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cargo = $_POST['cargo']; // Adicionando o campo de cargo
    
    // Inicialize o Firebase Factory
    $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    
    // Crie uma nova entrada no banco de dados
    $novoUsuario = $database->getReference('usuarios')->push([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha,
        'cargo' => $cargo // Adicionando o campo de cargo
    ]);
    
    // Verifique se o cadastro foi bem-sucedido
    if ($novoUsuario->getKey()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h2>Cadastrar Novo Usuário</h2>
    <form method="post">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br>
        <!-- Adicionando o campo de cargo -->
        <label for="cargo">Cargo:</label><br>
        <select id="cargo" name="cargo" required>
            <option value="1">Cargo 1</option>
            <option value="2">Cargo 2</option>
        </select><br><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
