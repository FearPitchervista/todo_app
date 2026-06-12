<?php

include "db.php";

$id = $_POST['id'];
$status = $_POST['status'];

$stmt = $conn->prepare("
    UPDATE taken
    SET status = ?
    WHERE id = ?
");

$stmt->bind_param("si", $status, $id);

$stmt->execute();
