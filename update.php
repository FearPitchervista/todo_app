<?php
// Database connectie importeren
include "db.php";

// Data ophalen uit het formulier
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$deadline = $_POST['deadline'];
$status = $_POST['status'];

// SQL query om taak te updaten (veilig met prepared statement)
$stmt = $conn->prepare("
    UPDATE taken 
    SET title = ?, description = ?, deadline = ?, status = ? 
    WHERE id = ?
");

// Waarden koppelen aan de query
$stmt->bind_param("ssssi", $title, $description, $deadline, $status, $id);

// Query uitvoeren
$stmt->execute();

// Terugsturen naar overzichtspagina
header("Location: index.php");
exit();
?>