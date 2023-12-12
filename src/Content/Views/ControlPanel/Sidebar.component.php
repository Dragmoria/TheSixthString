<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
    <ul class="nav nav-pills flex-column mb-auto">

        <?php
        foreach ($buttons as $button) {
            if ($button["enabled"]) {
                echo "<li class='nav-item'>";
                echo "<a href='{$button["path"]}' class='btn btn-primary nav-link link-body-emphasis " . ($button["path"] == $currentPath ? "active" : "") . " d-flex justify-content-between' aria-current='page'>";
                echo "{$button["text"]}<span class='badge text-bg-secondary'>{$button["notifications"]}</span>";
                echo "</a>";
                echo "</li>";
            }
        }
        ?>
    </ul>
</div>