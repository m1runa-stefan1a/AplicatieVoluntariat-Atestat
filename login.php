<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voluntariat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

$message = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identificare = mysqli_real_escape_string($conn, $_POST['identificare']);
    $parola = mysqli_real_escape_string($conn, $_POST['password']);

    $sql_user = "SELECT * FROM utilizatori WHERE username = '$identificare'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $row = $result_user->fetch_assoc();

        if (password_verify($parola, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: profil.php");
            exit();
        } else {
            $message = "<div class='error'>Parola incorectă pentru utilizator!</div>";
        }
    } else {
        $sql_admin = "SELECT * FROM administratori WHERE organizatie = '$identificare'";
        $result_admin = $conn->query($sql_admin);

        if ($result_admin->num_rows > 0) {
            $row = $result_admin->fetch_assoc();

            if (password_verify($parola, $row['parola'])) {
                $_SESSION['admin_id'] = $row['id'];
                header("Location: admin_profil.php");
                exit();
            } else {
                $message = "<div class='error'>Parola incorectă pentru administrator!</div>";
            }
        } else {
            $message = "<div class='error'>Utilizatorul sau administratorul nu a fost găsit!</div>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Logare</title>
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

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
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

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Logare</h2>

        <?php if (!empty($message)) echo $message; ?>

        <form action="login.php" method="POST">
            <label for="identificare">Nume utilizator / Organizație:</label><br>
            <input type="text" id="identificare" name="identificare" required><br><br>

            <label for="password">Parola:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Loghează-te">
        </form>
    </div>
</div>

</body>
</html>

