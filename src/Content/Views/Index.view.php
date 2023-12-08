<div>
    <h1>Index <span class="badge bg-secondary">Bootstrap badge</span></h1>

    <p><?php echo $messageOfTheDay ?></p>

    <?php include VIEWS_PATH . 'Partials/Boring.partial.php' ?>

    <div style="display: flex;">
        <?php
        foreach ($products as $product) {
            // echo component(COMPONENT_NAMESPACE . 'ProductComponent', $product); dit werkt ook maar die tweede is meer bug proof aangezien je met deze sneller een typo kan maken.
            echo component(Http\Controllers\Components\ProductComponent::class, $product);
        }
        ?>
    </div>

    <div>
        <form action="/" method="POST">
            <input type="hidden" name="_method" value="PUT" />
            <label for="textfield">Text Field:</label><br>
            <input type="text" id="textfield" name="textfield" value="<?php echo htmlspecialchars($oldValue ?? ''); ?>"><br>
            <input type="submit" value="Submit">
        </form>

        <?php if ($success) { ?>
            <div class="alert alert-primary" role="alert">
                <?php echo $success ?>
            </div>
        <?php } ?>
        
        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php } ?>
    </div>
</div>