<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voluntariat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$azi = date('Y-m-d');
$conn->query("DELETE FROM evenimente WHERE data < '$azi'");

$activitateId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM evenimente WHERE id = $activitateId";
$result = $conn->query($sql);
$eveniment = $result->fetch_assoc();

if ($eveniment) {
    $organizatorId = $eveniment['organizator_id'];

    $sqlOrganizator = "SELECT * FROM administratori WHERE id = $organizatorId";
    $resultOrganizator = $conn->query($sqlOrganizator);
    $organizator = $resultOrganizator->fetch_assoc();

    if ($organizator) {
        $organizatorNume = $organizator['nume'];
        $organizatorProfil = "profil_admin.php?id=" . $organizator['id'];
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Eveniment</title>
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
            max-width: 900px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color: #27ae60;
            margin-bottom: 30px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        strong {
            color: #2c3e50;
        }

        .btn-inregistrare {
            display: block;
            text-align: center;
            margin-top: 30px;
        }

        .btn-inregistrare a {
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn-inregistrare a:hover {
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
    <div class="container">
        <?php if ($eveniment): ?>
            <h2><?php echo htmlspecialchars($eveniment['nume_eveniment']); ?></h2>
            <img src="<?php echo htmlspecialchars($eveniment['imagine']); ?>" alt="<?php echo htmlspecialchars($eveniment['nume_eveniment']); ?>">

            <p><strong>📍 Locație:</strong> <?php echo htmlspecialchars($eveniment['locatie']); ?></p>
            <p><strong>📅 Data:</strong> <?php echo htmlspecialchars($eveniment['data']); ?></p>
            <p><strong>⏰ Ora:</strong> <?php echo htmlspecialchars($eveniment['ora']); ?></p>
            <p><strong>🎒 Descriere:</strong> <?php echo nl2br(htmlspecialchars($eveniment['descriere'])); ?></p>
            <p><strong><p><strong>🙏 Cum poți ajuta: </strong> <?php echo nl2br(htmlspecialchars($eveniment['cum_poti_ajuta'])); ?></p>
            <p><strong>🧑‍💼 Organizator:</strong> <?php echo htmlspecialchars($eveniment['organizator']); ?></p>

            <div class="btn-inregistrare">
                <a href="<?php echo htmlspecialchars($eveniment['link_formular']); ?>" target="_blank">
                    🎫 Înregistrează-te pentru a participa ca voluntar
                </a>
                </br>
                </br>
                </br>
                <a href="index.html" class="back-button">Înapoi la pagina principală</a>
            </div>

            <?php if (!empty($organizatorProfil)): ?>
                <div class="btn-inregistrare">
                    <a href="<?php echo $organizatorProfil; ?>">📞 Contactează organizatorul</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <h2>Evenimentul nu mai există.</h2>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
