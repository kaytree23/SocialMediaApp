function handle_post_submission($Post, $userid)
{
    $result = $Post->create_post($userid, $_POST, $_FILES);

    if ($result === "") {
        header("Location: single_post.php?id=" . $_GET['id']);
        exit;
    }

    return $result;
}
