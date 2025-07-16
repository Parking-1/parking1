<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=parking_db", "root", "");
    echo "Conexión exitosa!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
