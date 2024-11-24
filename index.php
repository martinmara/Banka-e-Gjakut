<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banka e Gjakut</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #0077b6;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0077b6;
        }
        form {
            margin-bottom: 20px;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #0077b6;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #005f8a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #0077b6;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Banka e Gjakut</h1>
    </header>
    <div class="container">
        <h2>Shto Donator ose Pacient</h2>
        <form method="POST">
            <input type="text" name="emer" placeholder="Emri" required>
            <input type="text" name="mbiemer" placeholder="Mbiemri" required>
            <input type="text" name="numer_telefoni" placeholder="Numri i Telefonit" required>
            <input type="text" name="grupi_gjakut" placeholder="Grupi i Gjakut (p.sh., O+)" required>
            <input type="number" name="sasia" placeholder="Sasia e Nevojshme (vetëm për pacientët)">
            <button type="submit" name="shto_donator">Shto Donator</button>
            <button type="submit" name="shto_pacient">Shto Pacient</button>
        </form>

        <h2>Lista e Donatorëve</h2>
        <?php
        // Lidhja me databazën
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'banka_e_gjakut';

        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Lidhja dështoi: " . $conn->connect_error);
        }

        // Funksionaliteti për të shtuar donator ose pacient
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $emer = $_POST['emer'];
            $mbiemer = $_POST['mbiemer'];
            $numer_telefoni = $_POST['numer_telefoni'];
            $grupi_gjakut = $_POST['grupi_gjakut'];

            if (isset($_POST['shto_donator'])) {
                $sql = "INSERT INTO donatore (emer, mbiemer, numer_telefoni, grupi_gjakut) 
                        VALUES ('$emer', '$mbiemer', '$numer_telefoni', '$grupi_gjakut')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p style='color: green;'>Donatori u shtua me sukses!</p>";
                } else {
                    echo "<p style='color: red;'>Gabim: " . $conn->error . "</p>";
                }
            }

            if (isset($_POST['shto_pacient'])) {
                $sasia = $_POST['sasia'];
                if (!empty($sasia)) {
                    $sql = "INSERT INTO pacient (emer, mbiemer, numer_telefoni, grupi_gjakut, sasia_e_nevojshme) 
                            VALUES ('$emer', '$mbiemer', '$numer_telefoni', '$grupi_gjakut', $sasia)";
                    if ($conn->query($sql) === TRUE) {
                        echo "<p style='color: green;'>Pacienti u shtua me sukses!</p>";
                    } else {
                        echo "<p style='color: red;'>Gabim: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Ju lutemi plotësoni sasinë për pacientët.</p>";
                }
            }
        }

        // Shfaq donatorët
        $sql_donator = "SELECT * FROM donatore";
        $result_donator = $conn->query($sql_donator);

        if ($result_donator->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Emri</th><th>Mbiemri</th><th>Nr. Telefoni</th><th>Grupi i Gjakut</th></tr>";
            while ($row = $result_donator->fetch_assoc()) {
                echo "<tr><td>{$row['id']}</td><td>{$row['emer']}</td><td>{$row['mbiemer']}</td>
                      <td>{$row['numer_telefoni']}</td><td>{$row['grupi_gjakut']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nuk ka donatorë të regjistruar.</p>";
        }

        // Shfaq pacientët
        echo "<h2>Lista e Pacientëve</h2>";
        $sql_pacient = "SELECT * FROM pacient";
        $result_pacient = $conn->query($sql_pacient);

        if ($result_pacient->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Emri</th><th>Mbiemri</th><th>Nr. Telefoni</th><th>Grupi i Gjakut</th><th>Sasia e Nevojshme</th></tr>";
            while ($row = $result_pacient->fetch_assoc()) {
                echo "<tr><td>{$row['id']}</td><td>{$row['emer']}</td><td>{$row['mbiemer']}</td>
                      <td>{$row['numer_telefoni']}</td><td>{$row['grupi_gjakut']}</td><td>{$row['sasia_e_nevojshme']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nuk ka pacientë të regjistruar.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
