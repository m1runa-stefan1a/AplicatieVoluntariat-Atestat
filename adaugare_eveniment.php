<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Eveniment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('uploads/voluntariat.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .form-container, .message-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 50px auto;
            width: 60%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="file"] {
            padding: 5px;
        }

        button {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #219150;
        }

        p {
            font-size: 18px;
            color: #2c3e50;
            text-align: center;
        }
        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<?php
$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "voluntariat");
    if ($conn->connect_error) {
        die("Conexiune eșuată: " . $conn->connect_error);
    }

    $titlu = $conn->real_escape_string($_POST['titlu']);
    $descriere = $conn->real_escape_string($_POST['descriere']);
    $cumPotiAjuta = $conn->real_escape_string($_POST['cum_poti_ajuta']);
    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $locatie = $conn->real_escape_string($_POST['locatie']);
    $judet = $conn->real_escape_string($_POST['judet']);
    $organizator = $conn->real_escape_string($_POST['organizator']);

    $imaginePath = "";
    if (isset($_FILES['imagine']) && $_FILES['imagine']['error'] === 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['imagine']['name']);
        $targetFile = $targetDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['imagine']['tmp_name'], $targetFile)) {
            $imaginePath = $targetFile;
        }
    }

    $organizator_id = 1;

    $stmt = $conn->prepare("INSERT INTO evenimente (nume_eveniment, locatie, data, ora, descriere, imagine, organizator_id, cum_poti_ajuta, judet) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $titlu, $locatie, $data, $ora, $descriere, $imaginePath, $organizator_id, $cumPotiAjuta, $judet);

    if ($stmt->execute()) {
        $mesaj = "✅ Evenimentul a fost adăugat cu succes!";
    } else {
        $mesaj = "❌ Eroare la adăugare: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php if (!empty($mesaj)): ?>
<div class="message-container">
    <p><?php echo $mesaj; ?></p>
</div>
<?php endif; ?>

<div class="form-container">
    <h2>Adaugă Eveniment</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="titlu">Titlu Eveniment:</label>
        <input type="text" id="titlu" name="titlu" required>

        <label for="descriere">Descriere:</label>
        <textarea id="descriere" name="descriere" required></textarea>

        <label for="cum_poti_ajuta">Cum poți ajuta:</label>
        <textarea id="cum_poti_ajuta" name="cum_poti_ajuta" required></textarea>

        <label for="imagine">Imagine:</label>
        <input type="file" id="imagine" name="imagine">

        <label for="data">Data Evenimentului:</label>
        <input type="date" id="data" name="data" required>

        <label for="ora">Ora Evenimentului:</label>
        <input type="time" id="ora" name="ora" required>

        <label for="locatie">Locație:</label>
        <input type="text" id="locatie" name="locatie" required>

        <label for="judet">Județ:</label>
        <select id="judet" name="judet" required>
            <option value="Bucuresti">București</option>
            <option value="Cluj">Cluj</option>
            <option value="Iasi">Iași</option>
            <option value="Brasov">Brașov</option>
            <option value="Buzau">Buzău</option>
        </select>

        <label for="organizator">Organizator:</label>
        <input type="text" id="organizator" name="organizator" required>

        <label for="link_inscriere">Link formular înscriere:</label>
        <input type="url" id="link_inscriere" name="link_inscriere" placeholder="https://exemplu.com/formular" required>
        <button type="submit" name="submit">Adaugă Eveniment</button>
        <br>
        <a href="index.html" class="back-button">🏠 Înapoi la pagina principală</a>
    </form>
</div>

</body>
</html>
