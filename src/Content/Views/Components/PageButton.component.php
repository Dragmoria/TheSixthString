<div class="col">
    <div class="card btn-card sixth-beige" style="<?php echo $enabled ? 'cursor: pointer; ' : 'opacity: 0.5;' ?>" path="<?php echo $path ?>" onclick="<?php echo $enabled ? $onClick : '' ?>">
        <div class="py-5 d-flex justify-content-center align-items-center">
            <span class="material-symbols-outlined" style="font-size: 6rem">
                <?php echo $icon; ?>
            </span>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
            <p class="h4"><?php echo $text; ?></p>
        </div>
    </div>
</div>
