<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="cadastrar.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="text" name="email" required><br>
        <button type="submit">Cadastrar</button>
    </form>

    <p><a href="listar.php">Listar usuários</a></p>

</body>
</html>
