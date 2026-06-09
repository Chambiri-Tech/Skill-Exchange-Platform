<?php
/** @var mysqli $conn */
session_start();

require_once "../include/config.php";
require_once "../include/header.php";

/* CHECK LOGIN */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* DELETE SKILL */
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: skills.php");
    exit();
}

/* ADD SKILL */
if (isset($_POST['add_skill'])) {

    $skill_name = trim($_POST['skill_name']);
    $skill_description = trim($_POST['skill_description']);

    $stmt = $conn->prepare(
        "INSERT INTO skills (skill_name, skill_description, user_id) VALUES (?, ?, ?)"
    );

    $stmt->bind_param("ssi", $skill_name, $skill_description, $user_id);
    $stmt->execute();

    header("Location: skills.php");
    exit();
}

/* LOAD EDIT DATA  */
$editSkill = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $stmt = $conn->prepare(
        "SELECT * FROM skills WHERE id = ? AND user_id = ?"
    );

    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $editSkill = $result->fetch_assoc();
}

/* UPDATE SKILL  */
if (isset($_POST['update_skill'])) {

    $id = (int) $_POST['id'];
    $skill_name = trim($_POST['skill_name']);
    $skill_description = trim($_POST['skill_description']);

    $stmt = $conn->prepare(
        "UPDATE skills 
         SET skill_name = ?, skill_description = ? 
         WHERE id = ? AND user_id = ?"
    );

    $stmt->bind_param("ssii", $skill_name, $skill_description, $id, $user_id);
    $stmt->execute();

    header("Location: skills.php");
    exit();
}

/* FETCH SKILLS  */
$stmt = $conn->prepare("
    SELECT skills.*, users.fullname
    FROM skills
    JOIN users ON skills.user_id = users.id
    WHERE skills.user_id = ?
    ORDER BY skills.id DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$skills = $stmt->get_result();
?>

<div class="main">

    <h2>Manage Skills</h2>

    <!-- ================= FORM ================= -->
    <form method="POST">

        <input type="hidden" name="id"
            value="<?php echo $editSkill['id'] ?? ''; ?>">

        <input type="text" name="skill_name"
            placeholder="Skill Name"
            value="<?php echo htmlspecialchars($editSkill['skill_name'] ?? ''); ?>"
            required>

        <textarea name="skill_description"
            placeholder="Skill Description"
            required><?php echo htmlspecialchars($editSkill['skill_description'] ?? ''); ?></textarea>

        <?php if ($editSkill): ?>
            <button name="update_skill">Update Skill</button>
        <?php else: ?>
            <button name="add_skill">Add Skill</button>
        <?php endif; ?>

    </form>

    <br>

    <div class="card-grid">

        <?php while ($row = $skills->fetch_assoc()): ?>

            <div class="card">

                <h3>
                    💡 <?php echo htmlspecialchars($row['skill_name']); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($row['skill_description']); ?>
                </p>

                <small>
                    👤 Posted by: <?php echo htmlspecialchars($row['fullname']); ?>
                </small>

                <br><br>

                <a class="action-btn"
                   href="skills.php?edit=<?php echo $row['id']; ?>">
                   Edit
                </a>

                <a class="delete-btn"
                   href="skills.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this skill?')">
                   Delete
                </a>

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php require_once "../include/footer.php"; ?>