<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activități Voluntariat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('uploads/voluntariat.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1100px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 10px;
        }

        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            margin: 30px 0;
            text-align: center;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 60%;
            max-width: 300px;
        }

        .activitati-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-content h4 {
            margin: 10px 0 5px;
            color: #27ae60;
        }

        .card-content p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }

        .card-content a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #27ae60;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .card-content a:hover {
            background-color: #219150;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <section class="container">
        <h2>Activități de voluntariat</h2>

        <form method="POST">
            <label for="judet">Alege județul:</label><br><br>
            <select name="judet" id="judet" onchange="this.form.submit()">
                <option value="">Selectează județul</option>
                <option value="Buzau">Buzău</option>
                <option value="Brasov">Brașov</option>
                <option value="Iasi">Iași</option>
                <option value="Cluj">Cluj</option>

            </select>
        </form>

        <?php
        $servername = "localhost";
        $username = "root";  
        $password = "";      
        $dbname = "voluntariat";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Conexiune eșuată: " . $conn->connect_error);
        }

        $judetSelectat = isset($_POST['judet']) ? $_POST['judet'] : '';

        if ($judetSelectat == '') {
            $sql = "SELECT * FROM evenimente";
        } else {
            $sql = "SELECT * FROM evenimente WHERE judet = ?";
        }

        $stmt = $conn->prepare($sql);

        if ($judetSelectat != '') {
            $stmt->bind_param("s", $judetSelectat);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<h3>Activități în ' . ($judetSelectat ?: 'toate județele') . '</h3>';
            echo '<div class="activitati-grid">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo    '<img src="' . $row['imagine'] . '" alt="' . htmlspecialchars($row['nume_eveniment']) . '">';
                echo    '<div class="card-content">';
                echo        '<h4>' . htmlspecialchars($row['nume_eveniment']) . '</h4>';
                echo        '<p>Locație: ' . htmlspecialchars($row['locatie']) . '</p>';
                echo        '<p>Data: ' . htmlspecialchars($row['data']) . '</p>';
                echo        '<a href="eveniment.php?id=' . $row['id'] . '">Vezi detalii</a>';
                echo    '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<h3>Nu există activități în acest județ încă.</h3>';
        }
        $stmt->close();
        $conn->close();
        ?>
    </br>
    <a href="index.html" class="back-button">Înapoi la pagina principală</a>
    </section>
</

