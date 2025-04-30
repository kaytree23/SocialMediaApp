<!-- forum_hp.php -->
<!--Homepage to navigate forums -->

<?php
session_start();

/* check if user is logged in */
if(!isset($_SESSION['username'])) 
{
    header("Location: login.php");
    exit();
}

$postsFile = "posts.txt";
$categoriesFile = "categories.txt";

/* preset categories */
$defaultCategories = [
    "General Discussion",
    "Health & Fitness",
    "Technology",
    "Travel & Adventure",
    "Food & Cooking",
    "Books & Literature",
    "Music & Arts"
    ];

/* load categories from file */
if(file_exists($categoriesFile))
    {
        $categories = array_filter(array_map('trim', file($categoriesFile)));
    }    
else
    {
        $categories = $defaultCategories;
    }

/* new category form submission */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_category"]) && !empty(trim($_POST["new_category"])))
    {
        $newCategory = htmlspecialchars(trim($_POST["new_category"]));
        if(!in_array(strtolower($newCategory), array_map('strtolower', $categories)))
            {
                file_put_contents($categoriesFile, $newCategory . "\n", FILE_APPEND);
                $categories[] = $newCategory;
            }   
    }

/* new post from user */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"], $_POST["category"]) && !empty($_POST["message"]) && !empty($_POST["category"]))
    {
        $username = htmlspecialchars($_SESSION["username"]);
        $category = htmlspecialchars(trim($_POST["category"]));
        $message = htmlspecialchars(trim($_POST["message"])); 
        $timestamp = date("Y-m-d H:i:s");
        $post = json_encode([
            "username" => $username,
            "category" => $category,
            "message" => $message,
            "timestamp" => time()
        ]);
        file_put_contents($postsFile, $post . "\n", FILE_APPEND);
    }

/* load posts */
$posts = [];
if (file_exists($postsFile))
    {
        $lines = file($postsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line)
        {
            $posts[] = json_decode($line, true);
        }
    }

/* search and filter through categories */
$search_query = $_GET['search'] ?? '';
$filter_category = $_GET['category'] ?? '';

if ($search_query)
    {
        $posts = array_filter($posts, function($post) use ($search_query) {
            return stripos($post['message'], $search_query) !== false;
        });
    }

if ($filter_category)
    {
        $posts = array_filter($posts, function($post) use ($filter_category) {
            return $post['category'] === $filter_category;
        });
    }

/* sort posts by timestamp */
usort($posts, function($a, $b) {
    return $b['timestamp'] - $a['timestamp'];
});
?>

/* HTML structure */
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connect with your Community</title>
    <style>
        body
        {
            font-family: 'Trebuchet MS', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-color: #F0FFF0;
            padding: 30px;
        }

        .forum-container
        {
            width: 700px;
            max-width: 90%;
            background-color: #FFFFFF;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h1, h2
        {
            text-align: center;
            color: #2F4F4F;
        }

        form
        {
            margin-bottom: 25px;
        }

        select, textarea, input[type="text"]
        {
            padding: 12px;
            border: 1px solid #8FBC8F;
            border-radius: 15px;
            font-size: 16px;
            background-color: #E8F5E9;
            color: #2F4F4F;
            margin-top: 8px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        select:focus, textarea:focus, input[type="text"]:focus
        {
            border-color: #66BB6A;
            background-color: #C8E6C9;
            outline: none;
        }

        .button-group
        {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        button
        {
            background-color: #8FBC8F;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .post
        {
            background-color: #F8FFF8;
            border: 1px solid #8FBC8F;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .post strong
        {
            color: #2F4F4F;
        }

        .post small
        {
            display: block;
            margin-top: 8px;
            color: #778899;
        }
    </style>
</head>

<body>
    <div class = "forum-container">
        <h1> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <h2>Create a New Post</h2>
        <form method = "post" action = "">
            <label>Category:
                <select name = "category" id = "post_category" required>
                    <?php foreach ($categories as $category): ?>
                        <option value = "<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
            </label><br><br>

            <label>Message:
                <textarea name = "message" id = "message" rows = "4" required placeholder = "Share a review, recommendation, or general thoughts..."></textarea>
            </label><br>

            <div class = "button-group">
                <button type = "submit">Post</button>
                <button type = "reset">Clear</button>
            </div>
        </form>

        <h2>Add a New Category</h2>
        <form method = "post" action = "">
            <input type = "text" name = "new_category" id = "new_category" placeholder = "Enter new category name..." required>
            <div class = "button-group">
                <button type = "submit">Add Category</button>
                <button type = "reset">Clear</button>
            </div>
        </form>

        <h2>Search Posts</h2>
        <form method = "get" action = "">
            <input type = "text" name = "search" id = "search" placeholder = "Search posts..." value = "<?php echo htmlspecialchars($search_query); ?>">
            <select name = "category" id = "search_category">
                <option value = "">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value = "<?php echo htmlspecialchars($category); ?>" <?php if ($filter_category == $category) echo 'selected'; ?>><?php echo htmlspecialchars($category); ?></option>
                <?php endforeach; ?>
            </select>
            <div class = "button-group">
                <button type = "submit">Search</button>
            </div>
        </form>

        <h2>Posts</h2>
        <div>
            <?php if (empty($posts)): ?>
                <p>No posts available.</p>
            <?php else: ?>
                <?php foreach (array_reverse($posts) as $post): ?>
                    <div class = "post">
                        <strong><?php echo htmlspecialchars($post['username']); ?></strong> posted in
                        <em><?php echo htmlspecialchars($post['category']); ?></em>:
                        <p><?php echo nl2br(htmlspecialchars($post['message'])); ?></p>
                        <small>Posted on <?php echo date("Y-m-d H:i:s", $post['timestamp']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>