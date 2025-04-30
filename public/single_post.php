<?php
session_start();
include("../classes/autoload.php");

function handle_post_submission($Post, $user_id) {
    if (!empty($_POST)) {
        $result = $Post->create_post($user_id, $_POST, $_FILES);
        if ($result === "") {
            // Redirect to prevent form resubmission
            $redirect_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            header("Location: single_post.php?id=$redirect_id");
            exit;
        } else {
            return $result; // Return error message
        }
    }
    return "";
}

// --- Initialize ---
$login = new Login();
$user_data = $login->check_login($_SESSION['mybook_userid']);
$USER = $user_data;

$Post = new Post();
$user = new User();
$image_class = new Image();
$error = "";
$ROW = false;

// --- Handle Post Submission ---
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $error = handle_post_submission($Post, $_SESSION['mybook_userid']);
}

// --- Get Post Data ---
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ROW = $Post->get_one_post($_GET['id']);
    if (!$ROW) {
        $error = "Post not found.";
    }
} else {
    $error = "Invalid post ID.";
}

// --- Set Title and Include Header ---
$title = "Single Post";
include(__DIR__ . '/../shared/header.php');
?>

<div class="post-page-container">
    <div class="post-box">
        <?php
        if (!empty($error)) {
            echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
        } elseif ($ROW):
            if (isset($_GET['notif'])) {
                notification_seen($_GET['notif']);
            }

            $ROW_USER = $user->get_user($ROW['userid']);

            if ($ROW['parent'] == 0) {
                include("post_delete.php");
            } else {
                $COMMENT = $ROW;
                include("comment.php");
            }
        ?>

            <?php if ($ROW['parent'] == 0): ?>
                <div class="comment-form">
                    <form method="post" enctype="multipart/form-data">
                        <textarea name="post" placeholder="Post a comment"></textarea>
                        <input type="hidden" name="parent" value="<?= htmlspecialchars($ROW['postid']) ?>">
                        <input type="file" name="file">
                        <button type="submit" class="post-button">Post</button>
                    </form>
                </div>
            <?php else: ?>
                <a href="single_post.php?id=<?= htmlspecialchars($ROW['parent']) ?>">
                    <button class="post-button" style="float: left;">Back to main post</button>
                </a>
            <?php endif; ?>

            <br style="clear:both;">

            <?php
            $comments = $Post->get_comments($ROW['postid']);
            if (is_array($comments)) {
                foreach ($comments as $COMMENT) {
                    $ROW_USER = $user->get_user($COMMENT['userid']);
                    include("comment.php");
                }
            }

            $pg = pagination_link();
            ?>

            <?php if ($ROW['parent'] == 0): ?>
                <a href="<?= $pg['next_page'] ?>"><button class="post-button" style="float: right; width:150px;">Next Page</button></a>
                <a href="<?= $pg['prev_page'] ?>"><button class="post-button" style="float: left; width:150px;">Prev Page</button></a>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

<?php include(__DIR__ . '/../shared/footer.php'); ?>
