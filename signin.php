<!-- <?php
session_start();
include 'connection.php';

$msg = 0; // Error message flag

if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $_SESSION['gender'] = $row['gender'];
            header("location:home.html");
            exit;
        } else {
            $msg = 1; // Password mismatch
        }
    } else {
        $msg = 2; // Account does not exist
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .logo {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .logo b {
            color: #06C167;
        }

        #heading {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .input {
            margin-bottom: 20px;
        }

        .input input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .password {
            position: relative;
        }

        .password input {
            width: 100%;
            padding-right: 40px;
        }

        .password i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn {
            text-align: center;
            margin-top: 20px;
        }

        .btn button {
            background-color: #06C167;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn button:hover {
            background-color: #049c4e;
        }

        .signin-up {
            text-align: center;
            margin-top: 15px;
        }

        .signin-up a {
            color: #06C167;
            text-decoration: none;
            font-weight: 500;
        }

        .signin-up a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <p class="logo">Food <b>Donate</b></p>
            <p id="heading">Welcome back!</p>

            <div class="input">
                <input type="email" placeholder="Email address" name="email" required />
            </div>

            <div class="password">
                <input type="password" placeholder="Password" name="password" id="password" required />
                <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <?php if ($msg == 1): ?>
                <p class="error">Password does not match.</p>
            <?php elseif ($msg == 2): ?>
                <p class="error">Account does not exist.</p>
            <?php endif; ?>

            <div class="btn">
                <button type="submit" name="sign">Sign in</button>
            </div>

            <div class="signin-up">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector(".showHidePw");
        const passwordField = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;
            togglePassword.classList.toggle("uil-eye");
        });
    </script>
</body>

</html> -->

<?php

include 'connection.php';

$msg = 0;
if (isset($_POST['sign'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['gender'] = $row['gender'];
                header("location:home.html");
            } else {
                $msg = 1;
            }
        }
    } else {
        echo "<h1><center>Account does not exist</center></h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #e1e1e1; /* Ash background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .regform {
            width: 100%;
            text-align: center;
        }

        .logo {
            font-size: 36px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .logo b {
            color: #06C167;
        }

        #heading {
            font-size: 22px;
            color: #555;
            margin-bottom: 20px;
        }

        .input,
        .password {
            width: 100%;
            margin-bottom: 20px;
        }

        .input input,
        .password input {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-top: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input input:focus,
        .password input:focus {
            border-color: #06C167;
            box-shadow: 0 0 5px rgba(245, 166, 35, 0.3); /* Light orange focus shadow */
            outline: none;
        }

        .password {
            position: relative;
        }

        .showHidePw {
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
        }

        .btn button {
            width: 100%;
            padding: 14px;
            border: none;
            background-color: #06C167;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn button:hover {
            background-color: #049c4e;
            box-shadow: 0 4px 8px rgba(245, 166, 35, 0.3); /* Light orange hover shadow */
        }

        .signin-up {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }

        .signin-up a {
            color: #06C167;
            text-decoration: none;
            font-weight: 600;
        }

        .signin-up a:hover {
            text-decoration: underline;
        }

        .error {
            color: #FF3B3B;
            font-size: 14px;
            margin-top: 10px;
        }

        .error-icon {
            color: #FF3B3B;
            font-size: 18px;
            margin-right: 5px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
                max-width: 90%;
            }

            .logo {
                font-size: 28px;
            }

            #heading {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="regform">
            <form action="" method="post">
                <p class="logo">Food <b>Donate</b></p>
                <p id="heading">Welcome back!</p>

                <div class="input">
                    <input type="email" placeholder="Email address" name="email" required />
                </div>

                <div class="password">
                    <input type="password" placeholder="Password" name="password" id="password" required />
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>

                    <?php
                    if ($msg == 1) {
                        echo ' <i class="bx bx-error-circle error-icon"></i>';
                        echo '<p class="error">Password not match.</p>';
                    }
                    ?>
                </div>

                <div class="btn">
                    <button type="submit" name="sign">Sign in</button>
                </div>

                <div class="signin-up">
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("showpassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            const icon = document.getElementById("showpassword");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("uil-eye-slash", "uil-eye");
            } else {
                passwordField.type = "password";
                icon.classList.replace("uil-eye", "uil-eye-slash");
            }
        });
    </script>
</body>
</html>