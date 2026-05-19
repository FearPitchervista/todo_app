<?php
// Verbinding met database
include "db.php";

// Checken of formulier is verzonden
if (isset($_POST['submit'])) {

    // Gegevens uit formulier halen
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    // Standaard status
    $status = "todo";

    // SQL query om taak toe te voegen
    $sql = "INSERT INTO tasks (title, description, status, deadline)
            VALUES ('$title', '$description', '$status', '$deadline')";

    // Uitvoeren
    if ($conn->query($sql)) {
        // terug naar overzicht na succes
        header("Location: index.php");
        exit();
    } else {
        echo "Fout: " . $conn->error;
    }
}
?>

<!-- HTML formulier -->
<h1>Nieuwe taak toevoegen</h1>

<form method="POST">

    <!-- Titel -->
    <label>Titel:</label><br>
    <input type="text" name="title" required><br><br>

    <!-- Beschrijving -->
    <label>Beschrijving:</label><br>
    <textarea name="description"></textarea><br><br>

    <!-- Deadline -->
    <label>Deadline:</label><br>
    <input type="date" name="deadline"><br><br>

    <!-- Knop -->
    <button type="submit" name="submit">Opslaan</button>

</form>

<br>

<!-- Terug link -->
<a href="index.php">← Terug</a>