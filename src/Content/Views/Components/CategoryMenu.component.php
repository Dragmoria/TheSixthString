<?php
?>

<style>
  .custom-dropdown:hover .dropdown-menu {
            display: block;
        }
</style>


<div class="dropdown custom-dropdown">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-sixth-beige" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Categorieën
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/Category">Alles tonen</a>
            <div class="dropdown-divider"></div>

        <?php
        foreach($categories as $category) {
            buildCategoryMenu($category, 0);
            ?>
            <div class="dropdown-divider"></div>
        <?php
        }
        ?>
    </div>
</li>