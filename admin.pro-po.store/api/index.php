<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn = "mysql:host=localhost;dbname=propo_database";
$username = "root";
$password = "W4&KhpizoBbnnp4N";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'));

    $request = "INSERT INTO {$body->table}";
    $arr_values = [];
    $arr_properties = [];

    foreach ($body->data as $property => $value) {
        $arr_properties[] = $property;
        $arr_values[] = ":$property";
    }

    $request .= " (" . implode(', ', $arr_properties) . ")";
    $request .= " VALUES (" . implode(', ', $arr_values) . ")";

    $stmt = $pdo->prepare($request);

    foreach ($body->data as $property => $value) {
        $stmt->bindValue(":$property", $value);
    }

    $result = $stmt->execute();

    if ($result) {
        $insertedId = $pdo->lastInsertId();
        $insertedElement = $pdo->query("SELECT * FROM {$body->table} WHERE id = $insertedId")->fetch(PDO::FETCH_ASSOC);
        echo json_encode($insertedElement);
    } else {
        echo "Insert failed.";
    }
} elseif ($method === 'PATCH') {
    $body = json_decode(file_get_contents('php://input'));

    $request = "UPDATE {$body->table} SET";
    $arr_changes = [];

    foreach ($body->data as $property => $value) {
        $arr_changes[] = "$property = :$property";
    }

    $request .= " " . implode(', ', $arr_changes);
    $request .= " WHERE id = :id";

    $stmt = $pdo->prepare($request);

    foreach ($body->data as $property => $value) {
        $stmt->bindValue(":$property", $value);
    }
    $stmt->bindValue(":id", $body->data->id);

    $result = $stmt->execute();

    if ($result) {
        $updatedElement = $pdo->query("SELECT * FROM {$body->table} WHERE id = {$body->data->id}")->fetch(PDO::FETCH_ASSOC);
        echo json_encode($updatedElement);
    } else {
        echo "Update failed.";
    }
} elseif ($method === 'DELETE') {
    $body = json_decode(file_get_contents('php://input'));

    $request = "DELETE FROM {$body->table} WHERE id = :id";

    $stmt = $pdo->prepare($request);
    $stmt->bindValue(":id", $body->data->id);

    $result = $stmt->execute();

    if ($result) {
        echo "success";
    } else {
        echo "Delete failed.";
    }
} else {
    echo 'you requested something';
}