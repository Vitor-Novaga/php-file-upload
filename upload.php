<?php
// Superglobals 
// $_GET, $_POST, $_FILES, $_SERVER

// validar o tipo de requisição
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return header('Location: index.php');
}

// validar o conteudo do formulario
if (!isset($_FILES['imagem'])) {
    return header('Location: index.php');
}

$imagem = $_FILES["imagem"];
$diretorioDestino = "upload/";

// validar o tipo e extensão de arquivo
$tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
$extensoesPermitidas = ['jpeg', 'jpg', 'png', 'webp'];

if (!in_array($imagem['type'], $tiposPermitidos)) {
    die('Tipo de arquivo inválido!');
}

$arquivoExtensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
if (!in_array($arquivoExtensao, $extensoesPermitidas)) {
    die('Extensão do arquivo inválida!');
}

$caminhoTemporario = $imagem["tmp_name"];

// Tratamento para nome de arquivo unico
$nomeUnico = uniqid() . '_' . $imagem["name"];
$caminhoDestino = $diretorioDestino . $nomeUnico;

$salvou = move_uploaded_file($caminhoTemporario, $caminhoDestino);

if ($salvou) {
    echo "Arquivo salvo em $caminhoDestino";
} else {
    echo "Erro ao salvar arquivo";
}