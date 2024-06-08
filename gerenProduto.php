<?php

require __dir__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['preco']) && !empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['preco'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $database->getReference('produtos')->push([
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco
        ]);
    } 
}


if (isset($_GET['delete'])) {
    $produto_id = $_GET['delete'];
    $factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $database->getReference('produtos/' . $produto_id)->remove();
}

$factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();
$contatos = $database->getReference('produtos')->getSnapshot();
$produtos = $contatos->getValue();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/gerenClientes.css">
    
</head>
<body>

<div class="container">
<div class="col-12" id="cad" >
        <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Cadastro de Produtos</h1>
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição::</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" class="form-control" id="preco" name="preco" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        </form>
    </div>

    <table class="table-responsive" id="listaprod" >
        <h2>Lista de Produtos</h2>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $key => $produto): ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['descricao']; ?></td>
                    <td><?php echo $produto['preco']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $key; ?>" class="btn btn-danger">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {
    var precoInput = document.getElementById('preco');
    precoInput.addEventListener('input', function (event) {
        var unformattedValue = this.value.replace(/[^\d]/g, '');
        var formattedValue = unformattedValue.replace(/\D/g, "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        this.value = formattedValue;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); 
            var produtoId = this.dataset.produtoId; 
        });
    });
});
</script>

</body>
</html>
