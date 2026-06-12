<?php
// Database connectie importeren
include "db.php";

// ID ophalen uit de URL (welke taak wordt bewerkt)
$id = $_GET['id'];

// Bestaande taak ophalen uit de database
$stmt = $conn->prepare("SELECT * FROM taken WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Resultaat omzetten naar bruikbare array
$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Taak bewerken</title>

    <!-- CSS bestand koppelen -->
    <link rel="stylesheet" href="stijl.css">
</head>

<body>

    <!-- Titel pagina -->
    <h1>Taak bewerken</h1>

    <!-- Formulier om taak te updaten -->
    <form action="update.php" method="POST">

        <!-- ID van taak (verborgen veld) -->
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

        <!-- Titel van taak -->
        <label>Titel:</label><br>
        <input type="text" name="title"
            value="<?php echo htmlspecialchars($task['title']); ?>"
            required>

        <br><br>

        <!-- Beschrijving -->
        <label>Beschrijving:</label><br>
        <textarea name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>

        <br><br>

        <!-- Deadline -->
        <label>Deadline:</label><br>
        <input type="date" name="deadline"
            value="<?php echo $task['deadline']; ?>">

        <br><br>

        <!-- Status kiezen -->
        <label for="status">Status:</label><br>

        <select name="status" id="status" class="status-select">

            <option value="todo" <?php if ($task['status'] == "todo") echo "selected"; ?>>
                📋 To Do
            </option>

            <option value="doing" <?php if ($task['status'] == "doing") echo "selected"; ?>>
                ⚙️ Doing
            </option>

            <option value="done" <?php if ($task['status'] == "done") echo "selected"; ?>>
                ✅ Done
            </option>

        </select>

        <br><br>

        <!-- Opslaan knop -->
        <button type="submit" name="submit">
            Opslaan
        </button>

    </form>

</body>

</html>