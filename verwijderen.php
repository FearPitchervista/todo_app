<?php
// Verbinding maken met de database
include "db.php";

// ID ophalen uit de URL (bijv. verwijderen.php?id=1)
$id = $_GET['id'];

// SQL query om de taak te verwijderen uit de tabel "tasks"
$sql = "DELETE FROM tasks WHERE id=$id";

// Query uitvoeren op de database
if ($conn->query($sql)) {

    // Als het verwijderen lukt:
    // terugsturen naar de overzichtspagina
    header("Location: index.php");
    exit();

} else {

    // Als er iets fout gaat, toon de foutmelding
    echo "Fout bij verwijderen: " . $conn->error;
}
?>