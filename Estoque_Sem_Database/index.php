<?php
// Carregar dados existentes
$dataFile = 'data.json';
$items = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $item = [
            'id' => uniqid(),
            'name' => $_POST['name'],
            'quantity' => (int)$_POST['quantity']
        ];
        $items[] = $item;
        file_put_contents($dataFile, json_encode($items));
        header("Location: index.php");
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $items = array_filter($items, fn($i) => $i['id'] !== $_POST['id']);
        file_put_contents($dataFile, json_encode(array_values($items)));
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Controle de Estoque</h1>

        <form method="POST" id="formAdd">
            <input type="hidden" name="action" value="add">
            <input type="text" name="name" placeholder="Nome do item" required>
            <input type="number" name="quantity" placeholder="Quantidade" min="1" required>
            <button type="submit">Adicionar</button>
        </form>

        <h2>Itens cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>
                            <form method="POST" class="inline-form" onsubmit="return confirmDelete()">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="delete">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($items) === 0): ?>
                    <tr><td colspan="3">Nenhum item no estoque.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="script.js"></script>
</body>
</html>