<?php
/** @var mysqli $conn */

session_start();
require_once "../../include/header.php";
require_once "../../include/config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../skills.php");
    exit();
}

/* DELETE USER */
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    // 1. delete related messages
    $stmt = $conn->prepare("DELETE FROM messages WHERE sender_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 2. delete related skills
    $stmt = $conn->prepare("DELETE FROM skills WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 3. delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: users.php");
    exit();
}
/* FETCH USERS */
$users = $conn->query("SELECT * FROM users");
?>

<h2>Manage Users</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php while($row = $users->fetch_assoc()): ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo $row['role']; ?></td>
    <td>
        <a href="users.php?delete=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>

<?php endwhile; ?>

</table>