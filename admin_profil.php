<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php');
    exit();
}

$host = 'localhost';
$db = 'voluntariat';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conectare eșuată: " . $conn->connect_error);
}

$admin_id = $_SESSION['admin_id'];

$admin_id = $conn->real_escape_string($admin_id);

$sql = "SELECT * FROM administratori WHERE id = '$admin_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "<p>Administratorul nu a fost găsit!</p>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Profil Organizator</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('uploads/voluntariat.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 420px;
            text-align: left;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #333;
            text-align: center;
        }

        p {
            margin: 8px 0;
            font-size: 16px;
            color: #555;
            display: flex;
            justify-content: space-between;
        }

        .profile-box p strong {
            width: 150px;
            text-align: left;
            font-weight: bold;
        }

        .profile-box p span {
            text-align: left;
            width: 100%;
        }

        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        .button-container {
            display: flex;
            justify-content: center; 
            margin-top: 20px;
        }

        .button-container a {
            margin: 5px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-box">
        <h2>Profil Organizator</h2>

        <p><strong>Nume:</strong> <span><?php echo htmlspecialchars($admin['nume']); ?></span></p>
        <p><strong>Prenume:</strong> <span><?php echo htmlspecialchars($admin['prenume']); ?></span></p>
        <p><strong>Telefon:</strong> <span><?php echo htmlspecialchars($admin['telefon']); ?></span></p>
        <p><strong>Email:</strong> <span><?php echo htmlspecialchars($admin['email']); ?></span></p>
        <p><strong>Județ:</strong> <span><?php echo htmlspecialchars($admin['judet']); ?></span></p>
        <p><strong>Organizație:</strong> <span><?php echo htmlspecialchars($admin['organizatie']); ?></span></p>

        <div class="button-container">
            <a href="edit_profil.php" class="button">Editează Profilul</a>
            <a href="adaugare_eveniment.php" class="button">Adaugă Eveniment</a> 
            <a href="logout_admin.php" class="button">Deconectează-te</a>
        </div>
    </div>
</div>

</body>
</html>
