<div>
    <h1>Hallo from index view</h1>
    <p>Tile is <?php echo $title ?></p>
    <p>Count is <?php echo $countSomething ?></p>
    <p><?php echo $someArray["key"] ?></p>
</div>


<form action="/postExample" method="post">
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="age" value="<?php echo $old['body']["age"] ?? "" ?>">
    <?php echo $errors["age"] ?? "" ?>

    <input type="submit" value="Submit">
</form>