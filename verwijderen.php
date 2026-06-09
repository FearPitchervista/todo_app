<?php
// Verbinding maken met de database
include "db.php";

//Controle of er wel een id is meegegeven
if (!isset($_GET['id'])) {
    die("Geen taak geselecteerd.");
}

// ID ophalen uit de URL (bijv. verwijderen.php?id=1)
$id = $_GET['id'];

// Een prepared statement maken om een taak veilig te verwijderen
// Het vraagteken (?) is een placeholder voor het ID
$stmt = $conn->prepare("DELETE FROM taken WHERE id = ?");

// Het ID koppelen aan de placeholder
// De "i" staat voor integer (een heel getal)
$stmt->bind_param("i", $id);

// De DELETE-query uitvoeren in de database
if ($stmt->execute()) {

    // Als het verwijderen lukt:
    // terugsturen naar de overzichtspagina
    header("Location: index.php");
    exit();

} else {

    // Als er iets fout gaat, toon de foutmelding
    echo "Fout bij verwijderen: " . $stmt->error;
}

// Het statement sluiten
$stmt->close();
?>