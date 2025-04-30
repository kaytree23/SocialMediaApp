<link rel="stylesheet" href="/SocialMediaApp/public/assets/styles.css">
<div class="single-post-preview">

    <?php 
        $image = "/SocialMediaApp/public/assets/images/user_male.jpg";
        if ($ROW_USER['gender'] === "Female") {
            $image = "/SocialMediaApp/public/assets/images/user_female.jpg";
        }

        $image_class = new Image();
        if (!empty($ROW_USER['profile_image']) && file_exists($ROW_USER['profile_image'])) {
            $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
        }
    ?>

    <div class="post-header">
        <img src="<?= htmlspecialchars($image) ?>" alt="Profile Picture" class="post-profile-pic">

        <div class="post-author-details">
            <strong><?= htmlspecialchars($ROW_USER['first_name'] . ' ' . $ROW_USER['last_name']) ?></strong>
            
            <?php if ($ROW['is_profile_image']): ?>
                <span class="post-meta"> updated <?= $ROW_USER['gender'] === 'Female' ? 'her' : 'his' ?> profile image</span>
            <?php elseif ($ROW['is_cover_image']): ?>
                <span class="post-meta"> updated <?= $ROW_USER['gender'] === 'Female' ? 'her' : 'his' ?> cover image</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="post-body">
        <?php if (!empty($ROW['post'])): ?>
            <p><?= nl2br(htmlspecialchars($ROW['post'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($ROW['image']) && file_exists($ROW['image'])): ?>
            <?php $post_image = $image_class->get_thumb_post($ROW['image']); ?>
            <img src="<?= htmlspecialchars($post_image) ?>" alt="Post Image" class="post-image">
        <?php endif; ?>
    </div>

</div>
