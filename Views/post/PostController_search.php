<?php if (!empty($posts)): ?>
    <div class="post-heading">
        <form action="<?= URL_ROOT ?>/post/search" class="post-search">
            <input type="text" name="query" class="post-search__input" placeholder="keyword...">
            <button type="submit" class="post-search__btn">search</button>
        </form>
        <a href="<?= URL_ROOT ?>/posts" class="create-post">Back</a>
    </div>
    <div class="post-wrapper">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3 class="post__title"><?= $post["title"] ?></h3>
                <span class="post__category-title"><?= $post["category_title"] ?></span>
                <p class="post__caption"><?= $post["body"] ?></p>
                <div class="post__links">
                    <a href="<?= URL_ROOT ?>/post/edit/<?= $post["id"] ?>" class="post__edit">Edit Post</a>
                    <form action="<?= URL_ROOT ?>/post/delete/<?= $post["id"] ?>" method="POST" class="post__delete">
                        <button type="submit" class="post__delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="paginate">
        <ul class="paginate__list">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="paginate__item">
                    <a href="<?= URL_ROOT ?>/post/search?query=<?= $query ?>&page=<?= $i ?>" class="paginate__link <?= $current_page == $i ? "paginate__active-page" : "" ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="no-post-wrapper">
        <a href="<?= URL_ROOT ?>/posts" class="create-no-post">Back</a>
        <p class="post-empty">There are no posts available.</p>
    </div>
<?php endif; ?>
