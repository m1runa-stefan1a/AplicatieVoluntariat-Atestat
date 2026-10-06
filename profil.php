<?php 
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db = 'voluntariat';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conectare eșuată: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

$sql_user = "SELECT * FROM utilizatori WHERE username = '$username'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows === 0) {
    echo "Utilizatorul nu a fost găsit!";
    exit();
}

$utilizator = $result_user->fetch_assoc();


$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilizator</title>
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

        .container {
            width: 500px;
            margin: 80px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        ul {
            padding-left: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px;
            border-radius: 5px;
        }

        .back-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Profilul tău</h2>

    <p><strong>Username:</strong> <?php echo htmlspecialchars($utilizator['username']); ?></p>
    <p><strong>Nume:</strong> <?php echo htmlspecialchars($utilizator['nume']); ?></p>
    <p><strong>Prenume:</strong> <?php echo htmlspecialchars($utilizator['prenume']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($utilizator['email']); ?></p>
    <p><strong>Telefon:</strong> <?php echo htmlspecialchars($utilizator['telefon']); ?></p>

    <h3>Activități de voluntariat:</h3>
    <?php if (empty($voluntariate)): ?>
        <p>Momentan nu ai activități înregistrate.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($voluntariate as $activitate): ?>
                <li><?php echo htmlspecialchars($activitate); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a class="back-link" href="index.html">Înapoi la pagina principală</a>
</div>

</body>
</html>
