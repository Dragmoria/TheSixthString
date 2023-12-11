<div class="d-flex flex-grow-1">
    <?php echo component(\Http\Controllers\ControlPanel\SidebarComponent::class); ?>

    <section class="py-5 text-center container">
        <div class="row">
            <div>
                <h1>Manage vouchers</h1>
                <p>voor <? echo $currentRole ?></p>
            </div>
        </div>
    </section>
</div>