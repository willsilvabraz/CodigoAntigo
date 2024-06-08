<?php
require __dir__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cliente_id']) && isset($_POST['produto_id']) && isset($_POST['quantidade']) && !empty($_POST['cliente_id']) && !empty($_POST['produto_id']) && !empty($_POST['quantidade'])) {
       
        $cliente_id = $_POST['cliente_id'];
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];

        $cliente = $database->getReference('clientes/' . $cliente_id)->getValue();
        $produto = $database->getReference('produtos/' . $produto_id)->getValue();


        if ($cliente && $produto) {
            $total = $produto['preco'] * $quantidade;

            $vendaRef = $database->getReference('vendas')->push([
                'cliente_id' => $cliente_id,
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
                'total' => $total,
                'data' => date("Y-m-d H:i:s")
            ]);

            $novoEstoque = $produto['estoque'] - $quantidade;
            $database->getReference('produtos/' . $produto_id . '/estoque')->set($novoEstoque);

            header("Location: vendas.php?success=1");
            exit();
        } else {
            echo "Cliente ou produto não encontrado...";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="col-lg-6">
        <h1>Realizar Venda</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>

                </select>
            </div>
            <div class="form-group">
                <label for="produto_id">Produto:</label>
                <select class="form-control" id="produto_id" name="produto_id" required>

                </select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Realizar Venda</button>
        </form>
    </div>
</div>

<script>
var clienteSelect = document.getElementById('cliente_id');
var produtoSelect = document.getElementById('produto_id');

function carregarClientes() {
    fetch('https://teste-dfb53-default-rtdb.firebaseio.com/clientes.json')
    .then(response => response.json())
    .then(data => {
        for (var key in data) {
            var option = document.createElement('option');
            option.value = key;
            option.textContent = data[key].nome + ' ' + data[key].sobrenome;
            clienteSelect.appendChild(option);
        }
    });
}

function carregarProdutos() {
    fetch('https://teste-dfb53-default-rtdb.firebaseio.com/produtos.json')
    .then(response => response.json())
    .then(data => {
        for (var key in data) {
            var option = document.createElement('option');
            option.value = key;
            option.textContent = data[key].nome;
            produtoSelect.appendChild(option);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    carregarClientes();
    carregarProdutos();
});
</script>

</body>
</html>
