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

$factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();

$vendas = $database->getReference('vendas')->getValue();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="col-lg-12">
        <h1>Listar Vendas...</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID da Venda</th>
                    <th>ID do Cliente</th>
                    <th>ID do Produto</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $key => $venda): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $venda['cliente_id']; ?></td>
                    <td><?php echo $venda['produto_id']; ?></td>
                    <td><?php echo $venda['quantidade']; ?></td>
                    <td><?php echo $venda['total']; ?></td>
                    <td><?php echo $venda['data']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
