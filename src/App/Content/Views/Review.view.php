<?php
foreach($reviews as $review) {
    print($review->title . '<br />');
    print($review->product->name ?? "geen product aanwezig");
}

?>
