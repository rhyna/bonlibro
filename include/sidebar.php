<?php

$categories = Category::getAllCategories($conn);

$activeCategoryId = null;

if (isset($_GET['category'])) {
    $activeCategoryId = $_GET['category'];
}

if (isset($_GET['id'])) {
    $book = new Book();
    $sidebarBookItem = $book->getBook($conn, $_GET['id']);

    if ($sidebarBookItem) {
        $sidebarBookItemCategory = $sidebarBookItem->category_id;
        $activeCategoryId = $sidebarBookItemCategory;
    }
}

?>

<ul class="sidebar">
    <li class="sidebar-item">
        <a class="sidebar-item__link <?= strpos($_SERVER['REQUEST_URI'], 'discount.php') !== false ? 'active' : '' ?>"
               href="<?= $ROOT_URL ?>/discount.php?page=1">АКЦИИ</a>
    </li>
    <?php foreach ($categories as $category): ?>
        <li class="sidebar-item">
            <a class="sidebar-item__link <?= $category['id'] == $activeCategoryId ? 'active' : '' ?>"
               href="<?= $ROOT_URL ?>/category.php?category=<?= $category['id'] ?>&page=1"><?= $category['name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>
