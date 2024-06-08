<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cargo'])) {
    header("Location: login.php");
    exit();
}

require __dir__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['endereco']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['cpf']) && isset($_POST['cnpj']) && !empty($_POST['nome']) && !empty($_POST['sobrenome']) && !empty($_POST['endereco']) && !empty($_POST['email']) && !empty($_POST['telefone']) && !empty($_POST['cpf']) || !empty($_POST['cnpj'])) {
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $endereco = $_POST['endereco'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $cnpj = $_POST['cnpj'];

        $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $database->getReference('clientes')->push([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'endereco' => $endereco,
            'email' => $email,
            'telefone' => $telefone,
            'cpf' => $cpf,
            'cnpj' => $cnpj
        ]);
    } 
}

if (isset($_GET['delete'])) {
    $cliente_id = $_GET['delete'];
    $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $database->getReference('clientes/' . $cliente_id)->remove();
}

$factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();
$contatos = $database->getReference('clientes')->getSnapshot();
$clientes = $contatos->getValue();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .compact-table {
        max-height: 300px;
        overflow-y: auto;
    }
    .compact-table th, .compact-table td {
        padding: 5px;
    }
</style>

</head>
<body>

<div class="container">
<div class="col-12" id="cad">
        <form method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Cadastro de Clientes</h1>
            
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required placeholder="Digite seu Nome">
            </div>
            <div class="form-group">
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required placeholder="Digite seu Sobrenome">
            </div>
            <div class="form-group">
                <label for="cepInput">CEP:</label>
                <input type="text" class="form-control" id="cepInput" name="cep" onchange="buscarEndereco()" required placeholder="EX: 44055-23">
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required placeholder="Digite seu Endereço">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu Email">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required placeholder="(00) 00000-0000">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00">
            </div>
            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0001-00">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
    </div>



    <table class="table compact-table" id="listacli" >
        <h2>Lista de Clientes</h2>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>CNPJ</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $key => $cliente): ?>
                <tr>
                    <td><?php echo $cliente['nome']; ?></td>
                    <td><?php echo $cliente['sobrenome']; ?></td>
                    <td><?php echo $cliente['endereco']; ?></td>
                    <td><?php echo $cliente['email']; ?></td>
                    <td><?php echo $cliente['telefone']; ?></td>
                    <td><?php echo $cliente['cpf']; ?></td>
                    <td><?php echo $cliente['cnpj']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $key; ?>" class="btn btn-danger">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./scripts/gerenClientes.js"></script>



</body>
</html>

