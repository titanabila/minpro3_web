<?php
require_once('database.php');

// Fungsi untuk memeriksa login
function checkLogin($conn, $username, $pw) {
    $query = "SELECT * FROM login WHERE username='$username' AND pw='$pw'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// // Jika form login dikirim
// if(isset($_POST['login'])) {
//     $username = $_POST['username'];
//     $pw = $_POST['pw'];

//     // Memeriksa login
//     $user = checkLogin($conn, $username, $pw);

//     if($user) {
//         // Login berhasil, arahkan ke index.php
//         header("Location: index.php");
//         exit();
//     } else {
//         // Login gagal
//         echo "Login gagal. Silakan coba lagi.";
//     }
// }

// Jika form registrasi dikirim
if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $pw = $_POST['pw'];

    $query = "INSERT INTO login (username, pw) VALUES ('$username', '$pw')";
    $result = mysqli_query($conn, $query);

    if($result) {
        echo "Registrasi berhasil.";
    } else {
        echo "Registrasi gagal.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            width: 400px;
            margin: 100px auto;
        }

        .register-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #ff2f2f;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background-color: #ff6a6a;
        }

        .error-msg {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2>Register</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pw" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="register" value="Register">
                </div>
            </form>
            <?php
            if(isset($error_msg)) {
                echo '<div class="error-msg">'.$error_msg.'</div>';
            }
            ?>
            <p>Sudah memiliki akun? <a href="login.php">Masuk di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
