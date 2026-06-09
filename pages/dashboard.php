<?php
session_start();

require_once __DIR__ . "/../include/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="sidebar">

    <h3>Skill Exchange</h3>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="skills.php">📚 My Skills</a>
    <a href="view_skills.php">🔍 Browse Skills</a>
    <a href="messages.php">💬 Messages</a>
    <a href="../logout.php">🚪 Logout</a>

</div>

<div class="main">

    <h2>
        Welcome,
        <?php echo htmlspecialchars($user['fullname']); ?> 👋
    </h2>

    <div class="card-grid">

        <div class="card">
            <h3>My Skills</h3>
            <p>
                Manage the skills you can teach others.
            </p>
        </div>

        <div class="card">
            <h3>Browse Skills</h3>
            <p>
                Discover skills offered by other users.
            </p>
        </div>

        <div class="card">
            <h3>Messages</h3>
            <p>
                Communicate with other members.
            </p>
        </div>

        <div class="card">
            <h3>Profile</h3>
            <p>
                View and update your account information.
            </p>
        </div>

    </div>

</div>

</body>
</html>