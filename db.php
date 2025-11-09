<?php

// --- 1. Credenciais ---
$db_name = 'moviestar';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

// --- 2. Tentativa de Conexão com o Banco de Dados (moviestar) ---
try {
    // Tenta a conexão direta com o banco 'moviestar'
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    
    // Configura os atributos do PDO (boa prática)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // --- 3. SE O BANCO NÃO EXISTIR (Erro 1049 - Unknown database) ---
    if ($e->getCode() === 1049) {
        
        echo "Banco de dados '$db_name' não encontrado. Tentando criar e configurar...<br>";

        // Tenta conectar APENAS ao servidor MySQL
        try {
            $conn = new PDO("mysql:host=$db_host;charset=utf8", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Cria o banco de dados 'moviestar'
            $sql_create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
            $conn->exec($sql_create_db);
            echo "Banco de dados '$db_name' criado com sucesso.<br>";
            
            // Re-conecta ao banco de dados recém-criado
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // --- 4. Executa o Script de Criação de Tabelas (schema.sql) ---
            $sql_schema = file_get_contents('schema.sql');
            
            // Para executar múltiplas queries em um único string, o PDO precisa que você as execute
            // individualmente ou, de forma mais simples, usando o método exec() em um arquivo lido.
            if ($conn->exec($sql_schema) !== false) {
                 echo "Tabelas criadas ou já existentes (schema.sql).<br>";
            } else {
                 die("Erro ao executar script SQL.");
            }
            
        } catch (PDOException $e_server) {
            die("Erro fatal na conexão ou criação do DB: " . $e_server->getMessage());
        }

    } else {
        // Lidar com outros erros (credenciais erradas, host inacessível, etc.)
        die("Erro de conexão com o banco de dados: " . $e->getMessage());
    }
}
// Agora a variável $conn está pronta para uso, seja na primeira conexão, ou após a criação.

?>