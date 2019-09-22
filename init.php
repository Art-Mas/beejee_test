<?php

$host = readline('DB HOST: ');
$db = readline('DB NAME: ');
$user = readline('DB USER NAME: ');
$pass = readline('DB PASSWORD: ');


$search = [
    '%%DB_HOST%%',
    '%%DB_NAME%%',
    '%%DB_USER%%',
    '%%DB_PASS%%',
    '%%DB_PORT%%',
];

$replace = [
    $host,
    $db,
    $user,
    $pass ? $pass : "''",
];

$phinxContent = file_get_contents('phinx.yml.example');
$phinxContent = str_replace($search, $replace, $phinxContent);
file_put_contents('phinx.yml', $phinxContent);

$envContent = file_get_contents('.env.example');
$envContent = str_replace($search, $replace, $envContent);
file_put_contents('.env', $envContent);

echo 'trying create db ' . $db . '...' . "\n" ;
try {
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE $db CHARACTER SET utf8 COLLATE utf8_general_ci";
    $conn->exec($sql);
    echo "Database created successfully" . "\n" ;
} catch (PDOException $e) {
    echo $sql . "\n" . $e->getMessage();
}

echo 'END';
