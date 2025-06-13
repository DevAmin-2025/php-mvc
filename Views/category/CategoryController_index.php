<div class="table-wrapper">
    <div class="category-index">
        <h2 class="category-index__title">Categories</h2>
        <a href="<?= URL_ROOT ?>/category/create" class="category-index__create">Create</a>
    </div>
    <table class="category-table">
        <thead class="thead">
            <tr class="category-table__row">
                <th class="category-table__header">Title</th>
                <th class="category-table__header">Action</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($categories as $category): ?>
                <tr class="category-table__row">
                    <td class="category-table__item"><?= $category["title"] ?></td>
                    <td class="category-table__item">
                        <div class="action-wrapper">
                            <a href="<?= URL_ROOT ?>/category/edit/<?= $category["category_id"] ?>" class="category-table__edit">Edit</a>
                            <form action="<?= URL_ROOT ?>/category/delete/<?= $category["category_id"] ?>" method="POST" class="delete-form">
                                <input type="submit" value="Delete" class="delete-form__btn">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginate">
        <ul class="paginate__list">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="paginate__item">
                    <a href="<?= URL_ROOT ?>/category?page=<?= $i ?>" class="paginate__link <?= $current_page == $i ? "paginate__active-page" : "" ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
