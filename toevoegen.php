<?php
// Databaseverbinding laden vanuit db.php
include "db.php";

// Controleren of het formulier is verzonden
if (isset($_POST['submit'])) {

    // De ingevulde gegevens uit het formulier ophalen
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    // Nieuwe taken krijgen standaard de status "todo"
    $status = "todo";

    // Controleren of de titel niet leeg is
    // trim() verwijdert eventuele spaties voor en achter de tekst
    if (empty(trim($title))) {
        die("De titel mag niet leeg zijn.");
    }

    // Een prepared statement maken
    // De vraagtekens (?) zijn tijdelijke plaatsaanduidingen voor de gegevens
    $stmt = $conn->prepare(
        "INSERT INTO taken (title, description, status, deadline)
         VALUES (?, ?, ?, ?)"
    );

    // De variabelen koppelen aan de placeholders
    // "ssss" betekent dat alle vier de waarden strings (tekst) zijn
    $stmt->bind_param("ssss", $title, $description, $status, $deadline);

    // De query uitvoeren
    if ($stmt->execute()) {

        // Na het succesvol toevoegen van een taak
        // wordt de gebruiker teruggestuurd naar het overzicht
        header("Location: index.php");
        exit();

    } else {

        // Een foutmelding tonen als het toevoegen mislukt
        echo "Fout: " . $stmt->error;
    }

    // Het statement sluiten om geheugen vrij te maken
    $stmt->close();
}
?>

<!-- HTML formulier voor het toevoegen van een nieuwe taak -->
<h1>Nieuwe taak toevoegen</h1>

<form method="POST">

    <!-- Invoerveld voor de titel van de taak -->
    <label>Titel:</label><br>
    <input type="text" name="title" required><br><br>

    <!-- Tekstvak voor een optionele beschrijving -->
    <label>Beschrijving:</label><br>
    <textarea name="description"></textarea><br><br>

    <!-- Datumveld voor de deadline -->
    <label>Deadline:</label><br>
    <input type="date" name="deadline"><br><br>

    <!-- Knop om het formulier te versturen -->
    <button type="submit" name="submit">Opslaan</button>

</form>

<br>

<!-- Link om terug te gaan naar het takenoverzicht -->
<a href="index.php">← Terug</a>