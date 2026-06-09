<?php
session_start();
require_once __DIR__ . "/../include/config.php";
require_once __DIR__ . "/../include/header.php";

// SEARCH VALUE
$search = isset($_GET['search']) ? $_GET['search'] : '';

// MAIN QUERY (with JOIN users)
$sql = "SELECT skills.*, users.fullname FROM skills JOIN users ON skills.user_id = users.id";

// ADD SEARCH FILTER
if (!empty($search)) {
    $safe_search = mysqli_real_escape_string($conn, $search);
    $sql .= " WHERE skills.skill_name LIKE '%$safe_search%'";
}

$sql .= " ORDER BY skills.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!-- PAGE CONTAINER -->
<div class="main">

    <h2>Browse Skills</h2>

    <!-- SEARCH BAR -->
    <form method="GET" style="max-width:400px; margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search skills..."
               value="<?php echo htmlspecialchars($search); ?>">
    </form>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <div class="card-grid">

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="card">

                    <h3>
                        💡 <?php echo htmlspecialchars($row['skill_name']); ?>
                    </h3>

                    <p>
                        <?php echo htmlspecialchars($row['skill_description']); ?>
                    </p>

                    <!-- USER INFO -->
                    <small style="color:#6b7280; display:block; margin-top:10px;">
                        👤 Posted by: <?php echo htmlspecialchars($row['fullname']); ?>
                    </small>

                    <!-- DATE -->
                    <small style="color:#6b7280; display:block;">
                        📅 <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                    </small>

                    <!-- ACTION BUTTON -->
                   <a href="skill_request.php?id=<?php echo $row['id']; ?>" 
                    style="
                    display:inline-block;
                    margin-top:12px;
                    padding:8px 12px;
                    background:#6366f1;
                    color:white;
                    border-radius:8px;
                    text-decoration:none;
                    font-size:13px;">
                    Request Skill
                    </a>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="card">
            <h3>No Skills Found</h3>
            <p>Try searching something else or check back later.</p>
        </div>

    <?php } ?>

</div>

<?php include "../include/footer.php"; ?>