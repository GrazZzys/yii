<?php

$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;port=3306;dbname=news',
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];