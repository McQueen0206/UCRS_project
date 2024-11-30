<?PHP
session_start();
include("database.php");

$msg = "";

if (isset($_POST['pwdrst'])) {
    $email = trim($_POST['email']);
    $pwd = password_hash(trim($_POST['pwd']), PASSWORD_DEFAULT);
    $cpwd = trim($_POST['cpwd']);

    // Check if the passwords match
    if (password_verify($cpwd, $pwd)) {
        $reset_pwd = mysqli_query($con, "UPDATE student SET password='$pwd' WHERE email='$email'");

        if ($reset_pwd) {
            $msg = 'Your password has been updated successfully. <a href="login.php">Click here</a> to login.';
        } else {
            $msg = "Error while updating the password.";
        }
    } else {
        $msg = "Password and Confirm Password do not match.";
    }
}

// Verify the reset link
if (isset($_GET['secret'])) {
    $email = base64_decode($_GET['secret']);
    $check_details = mysqli_query($con, "SELECT email FROM student WHERE email='$email'");

    if (mysqli_num_rows($check_details) > 0) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: url('images/banner.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-weight: 700;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h3 align="center">Reset Password</h3>
    <form method="post">
        <input type="hidden" name="email" value="<?php echo $email; ?>"/>
        <div class="form-group">
            <label for="pwd">New Password</label>
            <input type="password" name="pwd" id="pwd" placeholder="Enter New Password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cpwd">Confirm Password</label>
            <input type="password" name="cpwd" id="cpwd" placeholder="Enter Confirm Password" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" name="pwdrst" value="Reset Password" class="btn">
        </div>
        <p class="error"><?php if (!empty($msg)) { echo $msg; } ?></p>
    </form>
</div>
</body>
</html>
<?php
    } else {
        echo "<div style='text-align:center; margin-top:50px;'><h3>Invalid or expired reset link.</h3><a href='passwordreset.php'>Try Again</a></div>";
    }
}
?>
