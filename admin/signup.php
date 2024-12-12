<?php
include '../connection.php';
$msg = 0;
if (isset($_POST['sign'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $location = $_POST['district'];
    $address = $_POST['address'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "select * from admin where email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {

        $query = "insert into admin(name,email,password,location,address) values('$username','$email','$pass','$location','$address')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("data not saved")</script>';
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

        .title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .input-group,
        .input-field {
            width: 100%;
            margin-bottom: 20px;
        }

        .input-group label,
        .input-field select {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .input-group input,
        .input-field select,
        .input-group textarea {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-top: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus,
        .input-field select:focus,
        .input-group textarea:focus {
            border-color: #06C167;
            box-shadow: 0 0 5px rgba(245, 166, 35, 0.3); /* Light orange focus shadow */
            outline: none;
        }

        .password {
            position: relative;
        }

        .password input {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-top: 8px;
        }

        .showHidePw {
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
        }

        button[type="submit"] {
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

        button[type="submit"]:hover {
            background-color: #049c4e;
            box-shadow: 0 4px 8px rgba(245, 166, 35, 0.3); /* Light orange hover shadow */
        }

        .login-signup {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }

        .login-signup a {
            color: #06C167;
            text-decoration: none;
            font-weight: 600;
        }

        .login-signup a:hover {
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
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post" id="form">
            <span class="title">Register</span>
            <br>
            <div class="input-group">
                <label for="username">Name</label>
                <input type="text" id="username" name="username" required/>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required/>
            </div>

            <div class="password">
                <label class="textlabel" for="password">Password</label> 
                <input type="password" name="password" id="password" required/>
                <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
                <?php
                    if ($msg == 1) {
                        echo ' <i class="bx bx-error-circle error-icon"></i>';
                        echo '<p class="error">Password don\'t match.</p>';
                    }
                ?> 
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required></textarea>
            </div>

            <div class="input-field">
                <select id="district" name="district">
                    <option value="hyderabad">Hyderabad</option>
                    <option value="guntur">Guntur</option>
                    <option value="jabalpur" selected>Jabalpur</option>
                </select>
            </div>

            <button type="submit" name="sign">Register</button>

            <div class="login-signup">
                <span class="text">Already a member? <a href="signin.php" class="text login-link">Login Now</a></span>
            </div>
        </form>
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