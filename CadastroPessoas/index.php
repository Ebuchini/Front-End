<?php
    $dataFile = 'data.json';
    $pessoas = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

    // Adicionar ou editar pessoa
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'add') {
            $novaPessoa = [
                'id' => uniqid(),
                'nome' => $_POST['nome'],
                'rg' => $_POST['rg'],
                'cpf' => $_POST['cpf'],
                'nascimento' => $_POST['nascimento'],
                'estado_civil' => $_POST['estado_civil'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone'],
                'endereco' => $_POST['endereco'],
                'pais' => $_POST['pais'],
                'estado' => $_POST['estado']
            ];
            $pessoas[] = $novaPessoa;
                file_put_contents($dataFile, json_encode($pessoas, JSON_PRETTY_PRINT));
                header("Location: index.php");
                exit;
            } elseif ($_POST['action'] === 'edit') {
                foreach ($pessoas as &$p) {
                    if ($p['id'] === $_POST['id']) {
                        $p = array_merge($p, [
                            'nome' => $_POST['nome'],
                            'rg' => $_POST['rg'],
                            'cpf' => $_POST['cpf'],
                            'nascimento' => $_POST['nascimento'],
                            'estado_civil' => $_POST['estado_civil'],
                            'email' => $_POST['email'],
                            'telefone' => $_POST['telefone'],
                            'endereco' => $_POST['endereco'],
                            'pais' => $_POST['pais'],
                            'estado' => $_POST['estado']
                    ]);
                    break;
                }
            }
            file_put_contents($dataFile, json_encode($pessoas, JSON_PRETTY_PRINT));
            header("Location: index.php");
            exit;
    } elseif ($_POST['action'] === 'delete') {
        $pessoas = array_filter($pessoas, fn($p) => $p['id'] !== $_POST['id']);
            file_put_contents($dataFile, json_encode(array_values($pessoas), JSON_PRETTY_PRINT));
            header("Location: index.php");
            exit;
        }
    }

    // Filtros
    $filtro_nome = $_GET['filtro_nome'] ?? '';
    $filtro_estado = $_GET['filtro_estado'] ?? '';
    $filtro_pais = $_GET['filtro_pais'] ?? '';

    $pessoas = array_filter($pessoas, function ($p) use ($filtro_nome, $filtro_estado, $filtro_pais) {
        return 
        stripos($p['nome'], $filtro_nome) !== false &&
        stripos($p['estado'], $filtro_estado) !== false &&
        stripos($p['pais'], $filtro_pais) !== false;
    });

    $editando = null;
    if (isset($_GET['edit'])) {
        foreach ($pessoas as $p) {
        if ($p['id'] === $_GET['edit']) {
            $editando = $p;
            break;
            }
        }
    }
?>

<!DOCTYPE html>
    <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Cadastro de Pessoas</title>
            <link rel="stylesheet" href="style.css">
        </head>
    <body>
        <div class="container">
        <h1>Cadastro de Pessoas</h1>

        <form method="POST">
            <input type="hidden" name="action" value="<?= $editando ? 'edit' : 'add' ?>">
            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?= $editando['id'] ?>">
            <?php endif; ?>

            <input type="text" name="nome" placeholder="Nome completo" required value="<?= $editando['nome'] ?? '' ?>">
            <input type="text" name="rg" placeholder="RG" required value="<?= $editando['rg'] ?? '' ?>">
            <input type="text" name="cpf" placeholder="CPF" required value="<?= $editando['cpf'] ?? '' ?>">
            <input type="number" name="nascimento" placeholder="Ano de nascimento" required value="<?= $editando['nascimento'] ?? '' ?>">
            <select name="estado_civil" required>
                <option value="">Estado civil</option>
                <?php
                    $estadosCivis = ['Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)'];
                    foreach ($estadosCivis as $estado) {
                    $selected = isset($editando['estado_civil']) && $editando['estado_civil'] === $estado ? 'selected' : '';
                    echo "<option value='$estado' $selected>$estado</option>";}
                ?>
            </select>
                <input type="email" name="email" placeholder="E-mail" required value="<?= $editando['email'] ?? '' ?>">
                <input type="text" name="telefone" placeholder="Telefone" required value="<?= $editando['telefone'] ?? '' ?>">
                <input type="text" name="endereco" placeholder="Endereço completo" required value="<?= $editando['endereco'] ?? '' ?>">
                <input type="text" name="pais" placeholder="País" required value="<?= $editando['pais'] ?? '' ?>">
                <input type="text" name="estado" placeholder="Estado (UF)" required value="<?= $editando['estado'] ?? '' ?>">
                <button type="submit"><?= $editando ? 'Salvar Edição' : 'Cadastrar' ?></button>
        </form>

        <form method="GET" class="filtro-form">
            <input type="text" name="filtro_nome" placeholder="Filtrar por nome" value="<?= $filtro_nome ?>">
            <input type="text" name="filtro_estado" placeholder="Estado (UF)" value="<?= $filtro_estado ?>">
            <input type="text" name="filtro_pais" placeholder="País" value="<?= $filtro_pais ?>">
            <button type="submit">Filtrar</button>
            <a href="index.php" class="clear">Limpar</a>
        </form>

        <h2>Lista de Pessoas</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Nasc.</th>
                    <th>Estado Civil</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>País</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pessoas as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td><?= htmlspecialchars($p['rg']) ?></td>
                        <td><?= htmlspecialchars($p['cpf']) ?></td>
                        <td><?= htmlspecialchars($p['nascimento']) ?></td>
                        <td><?= htmlspecialchars($p['estado_civil']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['telefone']) ?></td>
                        <td><?= htmlspecialchars($p['endereco']) ?></td>
                        <td><?= htmlspecialchars($p['pais']) ?></td>
                        <td><?= htmlspecialchars($p['estado']) ?></td>
                        <td>
                            <a href="?edit=<?= $p['id'] ?>" class="edit">Editar</a>
                            <form method="POST" class="inline-form" onsubmit="return confirmDelete()">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="delete">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($pessoas) === 0): ?>
                <tr><td colspan="11">Nenhuma pessoa encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

        <script src="script.js"></script>
    </body>
</html>