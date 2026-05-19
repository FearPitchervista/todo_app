<?php
// Verbinding maken met de database
include "db.php";

// SQL-query: alle taken ophalen uit de tabel "tasks"
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>To-Do App</title>
</head>
<body>

    <!-- Hoofdtitel van de pagina -->
    <h1>Mijn taken</h1>

    <!-- Link naar pagina om nieuwe taak toe te voegen -->
    <a href="toevoegen.php">+ Nieuwe taak toevoegen</a>

    <ul>
        <?php
        // Controleren of er resultaten zijn
        // en elke taak één voor één tonen
        while ($row = $result->fetch_assoc()) {
        ?>
            <li>
                <!-- Titel van de taak -->
                <strong>
                    <?php echo $row['title']; ?>
                </strong>

                <!-- Status van de taak (bijv. todo, doing, done) -->
                - <?php echo $row['status']; ?>
            </li>
        <?php
        }
        ?>
    </ul>

</body>
</html>