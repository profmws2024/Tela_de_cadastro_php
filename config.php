<?php
// Dados de conexão com o banco de dados
$dbhost = 'localhost';    // Endereço do servidor MySQL
$dbuser = 'root';         // Nome de usuário do MySQL
$dbpass = '';             // Senha do MySQL
$dbname = 'formulario';   // Nome do banco de dados

// Criando a conexão com o banco de dados
$conexao = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Verificando se a conexão foi bem-sucedida
if ($conexao->connect_errno) {
    die("Falha ao conectar ao banco de dados: " . $conexao->connect_error);
} else{
    echo "<script>alert('Conexão bem-sucedida ao banco de dados!');</script>";}

// Criando a tabela 'usuarios' caso não exista
$query_create_table = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL
    )
";

if ($conexao->query($query_create_table) === TRUE) {
    // Tabela criada ou já existe
} else {
    die("Erro ao criar a tabela: " . $conexao->error);
}

// Verificando se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletando e limpando os dados do formulário
    if (isset($_POST['nome'], $_POST['email'])) {
        $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
        $email = mysqli_real_escape_string($conexao, trim($_POST['email']));

        // Verificando se os campos não estão vazios
        if (!empty($nome) && !empty($email)) {
            // Preparando a consulta SQL para inserir os dados na tabela
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $nome, $email);

            // Executando a consulta de inserção
            if ($stmt->execute()) {
                echo "<script>alert('Dados inseridos com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao inserir os dados: " . $stmt->error . "');</script>";
            }
}
    }
}
?>
