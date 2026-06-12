<?php
include "db.php";

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$deadline = $_POST['deadline'];
$status = $_POST['status'];

$stmt = $conn->prepare("
    UPDATE taken
    SET title = ?, description = ?, deadline = ?, status = ?
    WHERE id = ?
");

$stmt->bind_param("ssssi", $title, $description, $deadline, $status, $id);

$stmt->execute();

header("Location: index.php");
exit();
