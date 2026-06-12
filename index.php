<?php
// Verbinding maken met de database
include "db.php";

// Taken met status Todo ophalen
$todo = $conn->query("SELECT * FROM taken WHERE status = 'todo'");

// Taken met status Doing ophalen
$doing = $conn->query("SELECT * FROM taken WHERE status = 'doing'");

// Taken met status Done ophalen
$done = $conn->query("SELECT * FROM taken WHERE status = 'done'");

// Controle of de query goed is gegaan
if (!$todo || !$doing || !$done) {
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
    <button class="add-task-btn" onclick="openModal()">
        + Nieuwe taak toevoegen
    </button>

    <br><br>

    <!-- Overzicht van alle taken -->
    <!-- Trello bord -->
    <div class="board">

        <!-- TODO kolom -->
        <div class="column">
            <h2>Todo</h2>

            <?php while ($row = $todo->fetch_assoc()) { ?>

                <?php
                $colorClass = "";

                if (!empty($row['deadline'])) {

                    $today = new DateTime();
                    $deadline = new DateTime($row['deadline']);

                    $diff = $today->diff($deadline)->days;
                    $isFuture = $deadline >= $today;

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

                <div class="card <?php echo $colorClass; ?>" draggable="true" data-id="<?php echo $row['id']; ?>">
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Deadline: <?php echo htmlspecialchars($row['deadline']); ?></p>

                    <a href="verwijderen.php?id=<?php echo $row['id']; ?>">❌</a>
                    <a href="bewerken.php?id=<?php echo $row['id']; ?>">✏️</a>
                </div>

            <?php } ?>
        </div>

        <!-- DOING kolom -->
        <div class="column">
            <h2>Doing</h2>

            <?php while ($row = $doing->fetch_assoc()) { ?>

                <?php
                $colorClass = "";

                if (!empty($row['deadline'])) {

                    $today = new DateTime();
                    $deadline = new DateTime($row['deadline']);

                    $diff = $today->diff($deadline)->days;
                    $isFuture = $deadline >= $today;

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

                <div class="card <?php echo $colorClass; ?>" draggable="true" data-id="<?php echo $row['id']; ?>">
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Deadline: <?php echo htmlspecialchars($row['deadline']); ?></p>

                    <a href="verwijderen.php?id=<?php echo $row['id']; ?>">❌</a>
                    <a href="bewerken.php?id=<?php echo $row['id']; ?>">✏️</a>
                </div>

            <?php } ?>
        </div>

        <!-- DONE kolom -->
        <div class="column">
            <h2>Done</h2>

            <?php while ($row = $done->fetch_assoc()) { ?>

                <?php
                $colorClass = "";

                if (!empty($row['deadline'])) {

                    $today = new DateTime();
                    $deadline = new DateTime($row['deadline']);

                    $diff = $today->diff($deadline)->days;
                    $isFuture = $deadline >= $today;

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

                <div class="card <?php echo $colorClass; ?>" draggable="true" data-id="<?php echo $row['id']; ?>">
                    <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Deadline: <?php echo htmlspecialchars($row['deadline']); ?></p>

                    <a href="verwijderen.php?id=<?php echo $row['id']; ?>">❌</a>
                    <a href="bewerken.php?id=<?php echo $row['id']; ?>">✏️</a>
                </div>

            <?php } ?>
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
    <script src="script.js"></script>
</body>

</html>