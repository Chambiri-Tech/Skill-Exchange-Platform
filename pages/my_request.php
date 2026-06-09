<?php
session_start();
require_once __DIR__ . "/../include/config.php";
require_once __DIR__ . "/../include/header.php";

$user_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT skill_requests.*, skills.skill_name
     FROM skill_requests
     JOIN skills ON skill_requests.skill_id = skills.id
     WHERE skill_requests.requester_id='$user_id'
     ORDER BY skill_requests.id DESC"
);
?>

<div class="main">

    <h2>My Skill Requests</h2>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <div class="card-grid">

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="card">

                    <h3>
                        💡 <?php echo htmlspecialchars($row['skill_name']); ?>
                    </h3>

                    <p>
                        Status:
                        <strong>
                            <?php echo $row['status']; ?>
                        </strong>
                    </p>

                    <small style="color:#6b7280;">
                        📅 <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                    </small>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="card">
            <h3>No Requests Yet</h3>
            <p>You haven't requested any skills yet.</p>
        </div>

    <?php } ?>

</div>

<?php include "../include/footer.php"; ?>