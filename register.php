<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creare Cont</title>
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
            background-color: rgba(255, 255, 255, 0.8);
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
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="password"] {
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
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
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
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-box">
        <h2>Creare Cont</h2>

        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nume = $_POST['nume'];
            $prenume = $_POST['prenume'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $telefon = $_POST['telefon'];
            $oras = $_POST['oras'];
            $password = $_POST['password'];
            $conf_password = $_POST['conf_password'];

            if ($password !== $conf_password) {
                echo "<p class='error'>Parolele nu coincid! Te rugăm să le verifici.</p>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $servername = "localhost";
                $username_db = "root";
                $password_db = "";
                $dbname = "voluntariat";

                $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                if ($conn->connect_error) {
                    die("Conexiunea a eșuat: " . $conn->connect_error);
                }

                $sql = "INSERT INTO utilizatori (nume, prenume, username, email, telefon, oras, password) 
                        VALUES ('$nume', '$prenume', '$username', '$email', '$telefon', '$oras', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: profil.php");
                } else {
                    echo "<p class='error'>Eroare: " . $conn->error . "</p>";
                }

                $conn->close();
            }
        }
        ?>

        <form action="" method="POST">
            <label for="nume">Nume:</label><br>
            <input type="text" id="nume" name="nume" required><br>

            <label for="prenume">Prenume:</label><br>
            <input type="text" id="prenume" name="prenume" required><br>

            <label for="username">Nume utilizator:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Adresă de email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="telefon">Număr de telefon:</label><br>
            <input type="text" id="telefon" name="telefon" required><br>

            <label for="oras">Oraș:</label><br>
            <input type="text" id="oras" name="oras" required><br>

            <label for="password">Parola:</label><br>
            <input type="password" id="password" name="password" required><br>

            <label for="conf_password">Confirmă parola:</label><br>
            <input type="password" id="conf_password" name="conf_password" required><br><br>

            <input type="submit" value="Creează cont">
        </form>
        <br></br>
        <a href="index.html" class="back-button">Înapoi la pagina principală</a>

    </div>
</div>

</body>
</html>
