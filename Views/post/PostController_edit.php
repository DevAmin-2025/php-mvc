<div class="form-container">
    <div class="post-header">
        <h2 class="post-header__title">Edit Post</h2>
        <a href="<?= URL_ROOT ?>/posts" class="post-header__back">back</a>
    </div>
    <form action="<?= URL_ROOT ?>/post/update/<?= $post["id"] ?>" method="POST" class="post-create">
        <label for="title" class="post-create__label">Title</label><br>
        <input type="text" id="title" name="title" class="post-create__input" value="<?= $post["title"] ?>"><br>
        <?php if (isset($_SESSION["form_errors"]["title"])): ?>
            <p class="show-error-post"><?= $_SESSION["form_errors"]["title"] ?></p>
        <?php endif; ?>
        <label for="post-drop" class="post-create__label">Category</label><br>
        <select name="category_id" id="post-drop" class="post-create__drop">
            <?php foreach ($categories as $category): ?>
                <option <?= $category["category_id"] == $post["category_id"] ? "selected" : "" ?> value="<?= $category["category_id"] ?>" class="post-create__option"><?= $category["title"] ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="body" class="post-create__label">body</label><br>
        <textarea name="body" id="body" class="post-create__textarea" rows="5"><?= $post["body"] ?></textarea>
        <?php if (isset($_SESSION["form_errors"]["body"])): ?>
            <p class="show-error-post"><?= $_SESSION["form_errors"]["body"] ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION["form_errors"])): ?>
            <?php unset($_SESSION["form_errors"]) ?>
        <?php endif; ?>
        <input type="submit" class="post-create__submit">
    </form>
</div>
