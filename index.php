<?php
// Verbinding maken met de database
include "db.php";

// SQL-query: alle taken ophalen uit de tabel "taken"
$sql = "SELECT * FROM taken";
$result = $conn->query($sql);

// Controle of de query goed is gegaan
if (!$result) {
    die("Fout bij ophalen taken: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>To-Do App</title>

    <!-- Extern CSS-bestand laden -->
    <link rel="stylesheet" href="stijl.css">
</head>


<body>

    <!-- Hoofdtitel van de pagina -->
    <h1>Mijn taken</h1>

    <!-- Knop om de popup te openen -->
    <button onclick="openModal()">
        + Nieuwe taak toevoegen
    </button>

    <br><br>

    <!-- Overzicht van alle taken -->
    <ul>

        <?php while ($row = $result->fetch_assoc()) { ?>

    <?php
    // ===== KLEUR LOGICA PER TAAK =====

    $today = new DateTime();
    $deadline = new DateTime($row['deadline']);
    $diff = $today->diff($deadline)->days;
    $isFuture = $deadline >= $today;

    $colorClass = "";

    if (!empty($row['deadline'])) {

        if ($isFuture) {

            if ($diff <= 1) {
                $colorClass = "red";
            } elseif ($diff <= 7) {
                $colorClass = "orange";
            } else {
                $colorClass = "green";
            }

        } else {
            $colorClass = "red";
        }
    }
    ?>

    <!-- HIER GEBRUIK JE DE CLASS -->
    <li class="<?php echo $colorClass; ?>">

                <!-- Titel van de taak tonen -->
                <strong>
                    <?php echo htmlspecialchars($row['title']); ?>
                </strong>

                <!-- Status van de taak tonen -->
                - <?php echo htmlspecialchars($row['status']); ?>

                <!-- Verwijder knop -->
                <a href="verwijderen.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">

                    ❌ Verwijderen

                </a>
                <!-- Bewerk knop -->
                <a href="bewerken.php?id=<?php echo $row['id']; ?>">

                    ✏️ Bewerken
                </a>

                <p><?php echo htmlspecialchars($row['description']); ?></p>

                <p>Deadline: <?php echo htmlspecialchars($row['deadline']); ?></p>

            </li>

        <?php } ?>

    </ul>

    <div class="board">

    <div class="column">
        <h2>Todo</h2>
    </div>

    <div class="column">
        <h2>Doing</h2>
    </div>

    <div class="column">
        <h2>Done</h2>
    </div>

</div>

    <!-- Popupvenster voor het toevoegen van een taak -->
    <div id="taskModal" class="modal">

        <div class="modal-content">

            <!-- Sluitknop -->
            <span class="close" onclick="closeModal()">
                &times;
            </span>

            <h2>Nieuwe taak toevoegen</h2>

            <!-- Formulier voor het toevoegen van een taak -->
            <form action="toevoegen.php" method="POST">

                <!-- Titel invoeren -->
                <label>Titel:</label><br>

                <input type="text"
                       name="title"
                       required>

                <br><br>

                <!-- Beschrijving invoeren -->
                <label>Beschrijving:</label><br>

                <textarea name="description"></textarea>

                <br><br>

                <!-- Deadline kiezen -->
                <label>Deadline:</label><br>

                <input type="date"
                       name="deadline">

                <br><br>

                <!-- Formulier verzenden -->
                <button type="submit"
                        name="submit">

                    Opslaan

                </button>

            </form>

        </div>

    </div>

    <script>

        // Functie om de popup te openen
        function openModal() {

            document.getElementById("taskModal").style.display = "block";

        }

        // Functie om de popup te sluiten
        function closeModal() {

            document.getElementById("taskModal").style.display = "none";

        }

        // Popup sluiten wanneer buiten het venster wordt geklikt
        window.onclick = function(event) {

            let modal = document.getElementById("taskModal");

            if (event.target == modal) {

                modal.style.display = "none";

            }

        }

    </script>

</body>

</html>