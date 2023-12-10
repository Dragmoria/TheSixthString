<div class="sixth-tertiary">
    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Control panel</h1>
                <p>voor <? echo $currentRole ?></p>
            </div>
        </div>
    </section>
    <div class="py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php 
                    foreach($pageButtons as $pageButton) {
                        $pageButton["onClick"] = "goToPage(event)";
                        echo component(\Http\Controllers\Components\PageButtonComponent::class, $pageButton);
                    }
                ?>
            </div>
            <script>
                function goToPage(event) {
                    var clickedItem = event.currentTarget;
                    var path = clickedItem.getAttribute('path');
                    window.location.href = path;
                }
            </script>
        </div>
    </div>
</div>