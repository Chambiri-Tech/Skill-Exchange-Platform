<?php
session_start();

require_once "../include/config.php";
require_once "../include/header.php";

/* DELETE */
if(isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM skills WHERE id='$id'"
    );

    header("Location: skills.php");
    exit();
}

/* ADD */
if(isset($_POST['add_skill']))
{
    $skill_name = $_POST['skill_name'];
    $skill_description = $_POST['skill_description'];
    $user_id = $_SESSION['user_id'];

    mysqli_query(
        $conn,
        "INSERT INTO skills (skill_name, skill_description, user_id) VALUES ('$skill_name','$skill_description','$user_id')"
    );

    header("Location: skills.php");
    exit();
}

/* LOAD EDIT */
$editSkill = null;

if(isset($_GET['edit']))
{
    $id = (int)$_GET['edit'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM skills WHERE id='$id'"
    );

    $editSkill = mysqli_fetch_assoc($result);
}

/* UPDATE */
if(isset($_POST['update_skill']))
{
    $id = (int)$_POST['id'];

    $skill_name = $_POST['skill_name'];
    $skill_description = $_POST['skill_description'];

    mysqli_query(
        $conn,
        "UPDATE skills SET skill_name='$skill_name', skill_description='$skill_description' WHERE id='$id'"
    );

    header("Location: skills.php");
    exit();
}
?>

<div class="main">

    <h2>Manage Skills</h2>

    <form method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo $editSkill['id'] ?? ''; ?>">

        <input
            type="text"
            name="skill_name"
            placeholder="Skill Name"
            value="<?php echo $editSkill['skill_name'] ?? ''; ?>"
            required>

        <textarea
            name="skill_description"
            placeholder="Skill Description"
            required><?php echo $editSkill['skill_description'] ?? ''; ?></textarea>

        <?php if($editSkill){ ?>

            <button name="update_skill">
                Update Skill
            </button>

        <?php } else { ?>

            <button name="add_skill">
                Add Skill
            </button>

        <?php } ?>

    </form>

    <br>

    <?php

    $skills = mysqli_query(
        $conn,
        "SELECT skills.*, users.fullname FROM skills JOIN users ON skills.user_id = users.id ORDER BY skills.id DESC"
    );

    ?>

    <div class="card-grid">

        <?php while($row = mysqli_fetch_assoc($skills)){ ?>

            <div class="card">

                <h3>
                    💡 <?php echo htmlspecialchars($row['skill_name']); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($row['skill_description']); ?>
                </p>

                <small>
                    👤 Posted by:
                    <?php echo htmlspecialchars($row['fullname']); ?>
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

        <?php } ?>

    </div>

</div>

<?php require_once "../include/footer.php"; ?>