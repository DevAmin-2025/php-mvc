<div class="form-container">
    <div class="category-header">
            <h2 class="category-header__title">Edit Category</h2>
            <a href="<?= URL_ROOT ?>/category" class="category-header__back">back</a>
    </div>
    <form action="<?= URL_ROOT ?>/category/update/<?= $category["category_id"] ?>" method="POST" class="category-create">
        <label for="title" class="category-create__label">Title</label><br>
        <input type="text" id="title" name="title" value="<?= $category["title"] ?>" class="category-create__input"><br>
        <?php if (isset($_SESSION["form_errors"]["title"])): ?>
            <p class="show-error"><?= $_SESSION["form_errors"]["title"] ?></p>
            <?php unset($_SESSION["form_errors"]) ?>
        <?php endif; ?>
        <?php if (isset($_SESSION["form_errors"]["category"])): ?>
            <p class="show-error"><?= $_SESSION["form_errors"]["category"] ?></p>
            <?php unset($_SESSION["form_errors"]) ?>
        <?php endif; ?>
        <input type="submit" class="category-create__submit">
    </form>
</div>