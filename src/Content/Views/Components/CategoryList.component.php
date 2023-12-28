<?php
function buildCategoryList($category, int $depth): void {
    $maxDepth = 2;
    if($depth == $maxDepth) return;

    echo '<li class="m-0" style="padding-left: calc(3px + 0.5rem * ' . $depth . ');"><a class="text-decoration-none text-sixth-beige" href="/Category/' . $category->id . '">' . $category->name . '</a></li>';

    foreach ($category->children as $childCategory) {
        buildCategoryList($childCategory, ++$depth);
    }
}
?>

<ul class="list-unstyled text-sixth-beige">
    <?php
    foreach($categories as $category) {
        buildCategoryList($category, 0);
    }
    ?>
</ul>