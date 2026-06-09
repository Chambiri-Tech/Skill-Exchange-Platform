<?php
session_start();
require_once __DIR__ . "/../include/config.php";

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$skill_id = $_GET['id'];

// CHECK IF ALREADY REQUESTED
$check = mysqli_query(
    $conn,
    "SELECT * FROM skill_requests WHERE skill_id='$skill_id' AND requester_id='$user_id'"
);

if (mysqli_num_rows($check) > 0) {
    echo "You already requested this skill!";
    exit();
}

// INSERT REQUEST
mysqli_query(
    $conn,
    "INSERT INTO skill_requests (skill_id, requester_id) VALUES ('$skill_id', '$user_id')"
);

header("Location: my_requests.php");
exit();
?>