<?php
/** @var mysqli $conn */

session_start();
require_once "../../include/config.php";
require_once "../../include/header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../skills.php");
    exit();
}

/* STATS */
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$skills = $conn->query("SELECT COUNT(*) as total FROM skills")->fetch_assoc();
?>

<!-- NAVBAR -->
<div class="admin-nav">
    <h2>Skill Exchange Admin</h2>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="../skills.php">Exit</a>
    </div>
</div>

<!-- CONTENT -->
<div class="admin-container">

    <h1>Dashboard Overview</h1>

    <div class="stats">

        <div class="card">
            <h2>Total Users</h2>
            <p><?php echo $users['total']; ?></p>
        </div>

        <div class="card">
            <h2>Total Skills</h2>
            <p><?php echo $skills['total']; ?></p>
        </div>

    </div>

    <br><br>

    <div class="card">
        <h2>Quick Actions</h2>
        <br>

        <a href="users.php" class="btn-edit">Manage Users</a>
        <a href="skills.php" class="btn-edit">Manage Skills</a>
    </div>

</div>