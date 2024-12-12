<?php
session_start();
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include '../connection.php';
$msg=0;
if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
  $sanitized_password =  mysqli_real_escape_string($connection, $password);
  // $hash=password_hash($password,PASSWORD_DEFAULT);

  $sql = "select * from admin where email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['location'] = $row['location'];
        $_SESSION['Aid']=$row['Aid'];
        header("location:admin.php");
      } else {
        $msg = 1;
      }
    }
  } else {
    echo "<h1><center>Account does not exist </center></h1>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formstyle.css">
    <script src="signin.js" defer></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Login</title>
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
                <p id="heading">Admin Login</p>

                <div class="input">
                    <input type="text" placeholder="Email address" name="email" required />
                </div>

                <div class="password">
                    <input type="password" placeholder="Password" name="password" id="password" required />
                    <?php
                    if ($msg == 1) {
                        echo ' <i class="bx bx-error-circle error-icon"></i>';
                        echo '<p class="error">Password does not match.</p>';
                    }
                    ?>
                </div>

                <div class="btn">
                    <button type="submit" name="sign">Login</button>
                </div>

                <div class="signin-up">
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>