<?php

session_start();


$servername = "localhost";
$username = "root";  
$password = "";    
$dbname = "voluntariat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM administratori WHERE id = $admin_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<p>Administratorul nu a fost găsit!</p>";
    exit();
}

$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = mysqli_real_escape_string($conn, $_POST['nume']);
    $prenume = mysqli_real_escape_string($conn, $_POST['prenume']);
    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $judet = mysqli_real_escape_string($conn, $_POST['judet']);
    $organizatie = mysqli_real_escape_string($conn, $_POST['organizatie']);

    $update_sql = "UPDATE administratori SET nume='$nume', prenume='$prenume', telefon='$telefon', email='$email', judet='$judet', organizatie='$organizatie' WHERE id=$admin_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<p>Profilul a fost actualizat cu succes!</p>";
        header("Location: admin_profil.php");
        exit();
    } else {
        echo "<p>Eroare la actualizarea profilului: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Editează Profilul</title>
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

        .edit-profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 100px;
        }

        .edit-profile-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="edit-profile-container">
    <div class="edit-profile-box">
        <h2>Editează Profilul</h2>

        <form action="edit_profil.php" method="POST">
            <label for="nume">Nume:</label><br>
            <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($admin['nume']); ?>" required><br><br>

            <label for="prenume">Prenume:</label><br>
            <input type="text" id="prenume" name="prenume" value="<?php echo htmlspecialchars($admin['prenume']); ?>" required><br><br>

            <label for="telefon">Telefon:</label><br>
            <input type="tel" id="telefon" name="telefon" value="<?php echo htmlspecialchars($admin['telefon']); ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required><br><br>

            <label for="judet">Județ:</label><br>
            <input type="text" id="judet" name="judet" value="<?php echo htmlspecialchars($admin['judet']); ?>" required><br><br>

            <label for="organizatie">Organizație:</label><br>
            <input type="text" id="organizatie" name="organizatie" value="<?php echo htmlspecialchars($admin['organizatie']); ?>" required><br><br>

            <input type="submit" value="Salvează Modificările">
        </form>

        <br><br>

        <a href="admin_profil.php" class="back-button">Întoarce-te la Profil</a>
    </div>
</div>

</body>
</html>
