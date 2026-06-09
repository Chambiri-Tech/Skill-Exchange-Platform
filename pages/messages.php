<?php
session_start();

require_once "../include/config.php";
require_once "../include/header.php";

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* SEND MESSAGE */
if(isset($_POST['send']))
{
    $receiver_id = $_POST['receiver_id'];
    $message = mysqli_real_escape_string(
        $conn,
        $_POST['message']
    );

    mysqli_query(
        $conn,
        "INSERT INTO messages
        (sender_id, receiver_id, message)
        VALUES
        ('$user_id','$receiver_id','$message')"
    );

    echo "<div class='success'>Message sent successfully.</div>";
}

/* USERS LIST */
$users = mysqli_query(
    $conn,
    "SELECT id, fullname
     FROM users
     WHERE id != '$user_id'"
);
?>

<div class="main">

    <h2>Send Message</h2>

    <div class="card">

        <form method="POST">

            <label>Select User</label>

            <select name="receiver_id" required>

                <option value="">
                    Choose User
                </option>

                <?php while($user = mysqli_fetch_assoc($users)){ ?>

                    <option
                        value="<?php echo $user['id']; ?>">

                        <?php
                        echo htmlspecialchars(
                            $user['fullname']
                        );
                        ?>

                    </option>

                <?php } ?>

            </select>

            <textarea
                name="message"
                placeholder="Type your message..."
                required>
            </textarea>

            <button name="send">
                Send Message
            </button>

        </form>

    </div>

</div>

<?php require_once "../include/footer.php"; ?>