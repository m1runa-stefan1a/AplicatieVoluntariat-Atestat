<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare Organizator</title>
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

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 100px;
        }

        .register-box {
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

        input[type="text"], input[type="email"], input[type="password"] {
            width: 250px;
            padding: 8px;
            margin: 6px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }

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

<div class="register-container">
    <div class="register-box">
        <h2>Creare Cont Organizator</h2>

        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $telefon = $_POST['telefon'];
            $email = $_POST['email'];
            $judet = $_POST['judet'];
            $organizatie = $_POST['organizatie'];
            $password = $_POST['password'];
            $conf_password = $_POST['conf_password'];

            if ($password !== $conf_password) {
                echo "<p class='error'>Parolele nu coincid!</p>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $conn = new mysqli("localhost", "root", "", "voluntariat");

                if ($conn->connect_error) {
                    die("Conexiunea a eșuat: " . $conn->connect_error);
                }

                $sql = "INSERT INTO administratori (nume, prenume, telefon, email, judet, organizatie, parola) 
                        VALUES ('$nume', '$prenume', '$telefon', '$email', '$judet', '$organizatie', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: admin_profil.php");
                    exit();
                } else {
                    echo "<p class='error'>Eroare: " . $conn->error . "</p>";
                }

                $conn->close();
            }
        }
        ?>

        <form action="" method="POST">
            <input type="text" name="nume" placeholder="Nume" required><br>
            <input type="text" name="prenume" placeholder="Prenume" required><br>
            <input type="text" name="telefon" placeholder="Telefon" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="judet" placeholder="Județ" required><br>
            <input type="text" name="organizatie" placeholder="Organizație" required><br>
            <input type="password" name="password" placeholder="Parolă" required><br>
            <input type="password" name="conf_password" placeholder="Confirmă parola" required><br><br>
            <input type="submit" value="Creează cont">
        </form>

        <a href="index.html" class="back-button">Înapoi la pagina principală</a>
    </div>
</div>

</body>
</html>
