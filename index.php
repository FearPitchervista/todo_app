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
<?php while ($row = $result->fetch_assoc()) { ?>
    <li>
        <strong><?php echo $row['title']; ?></strong>
        - <?php echo $row['status']; ?>

        <!-- Verwijder knop -->
        <a href="verwijderen.php?id=<?php echo $row['id']; ?>" 
           onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">
           ❌ Verwijderen
        </a>
    </li>
<?php } ?>
</ul>
    

</body>
</html>