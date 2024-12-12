<?php
include 'connection.php';

if (isset($_POST['sign'])) {

    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    
    if ($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $query = "INSERT INTO login(name,email,password,gender) VALUES('$username','$email','$pass','$gender')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #e1e1e1;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(245, 166, 35, 0.3);   
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
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #555;
        }

        .input {
            width: 100%;
            margin-bottom: 15px;
            text-align: left;
        }

        .textlabel {
            font-size: 14px;
            color: #777;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            margin-top: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
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

        .radio {
            margin: 20px 0;
            text-align: left;
        }

        .radio input {
            margin-right: 10px;
        }

        .btn {
            margin-top: 20px;
        }

        .btn button {
            width: 100%;
            padding: 12px;
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

        @media (max-width: 600px) {
            .container {
                padding: 20px;
                max-width: 90%;
            }

            .logo {
                font-size: 28px;
            }

            #heading {
                font-size: 20px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <p class="logo">Food <b>Donate</b></p>
        <p id="heading">Create your account</p>

        <form action="" method="post">
            <div class="input">
                <label class="textlabel" for="name">Username</label>
                <input type="text" id="name" name="name" required />
            </div>

            <div class="input">
                <label class="textlabel" for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="input">
                <label class="textlabel" for="password">Password</label>
                <div class="password">
                    <input type="password" name="password" id="password" required />
                    <i class="fa-solid fa-eye showHidePw" id="showpassword"></i>
                </div>
            </div>

            <div class="radio">
                <input type="radio" name="gender" id="male" value="male" required />
                <label for="male">Male</label>
                <input type="radio" name="gender" id="female" value="female" />
                <label for="female">Female</label>
            </div>

            <div class="btn">
                <button type="submit" name="sign">Continue</button>
            </div>

            <div class="signin-up">
                <p>Already have an account? <a href="signin.php">Sign in</a></p>
            </div>
        </form>
    </div>
    
    <script>
        // Password visibility toggle
        document.getElementById("showpassword").addEventListener("click", function() {
            const passwordField = document.getElementById("password");
            const icon = document.getElementById("showpassword");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    </script>
</body>
</html>