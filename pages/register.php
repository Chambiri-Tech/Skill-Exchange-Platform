<?php
require_once __DIR__ . "/../include/config.php";

$error = "";

if (isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $error = "Email already exists!";

    } else {

        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {

            header("Location: login.php");
            exit();

        } else {

            $error = mysqli_error($conn);

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <h2>Create Account</h2>

        <?php if($error != "") { ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <input
                type="text"
                name="fullname"
                placeholder="Full Name"
                required>

            <input
                type="email"
                name="email"
                placeholder="Email Address"
                required>

            <input
                type="password"
                name="password"
                placeholder="Password"
                required>

            <button type="submit" name="register">
                Register
            </button>

        </form>

        <p>
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</div>

</body>
</html>