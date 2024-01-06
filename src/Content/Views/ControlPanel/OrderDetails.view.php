<div class="container mt-3">

    <div class="mb-3">
        <a href="/ControlPanel/OrderManagement" class="btn btn-primary">Back to Order Management</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Order Details</h2>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Order ID:
                <?= $order->id ?>
            </li>
            <li class="list-group-item">Items Count:
                <?= $order->orderItemsCount ?>
            </li>
            <li class="list-group-item">Order Total:
                <?= $order->orderTotal ?>
            </li>
            <li class="list-group-item">Order Tax:
                <?= $order->orderTax ?>
            </li>
            <li class="list-group-item">Payment Status:
                <?= $order->paymentStatus->name ?>
            </li>
            <li class="list-group-item">Shipping Status:
                <?= $order->shippingStatus->name ?>
            </li>
            <li class="list-group-item">Created On:
                <?= $order->createdOn->format('Y-m-d H:i:s') ?>
            </li>
        </ul>
    </div>

    <?php if ($order->shippingStatus->value == 0): ?>
        <form id="sendForm" onsubmit="sendData(event)">
            <button type="submit" class="btn btn-success mt-3">Mark as Sent</button>
        </form>
        <script>
            function sendData(event) {
                event.preventDefault();
                const formData = new FormData();
                formData.append('setToSent', 1);
                $.ajax({
                    url: location.pathname + '/SetShippingStatus',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        location.reload();
                    },
                    error: function () {
                        alert('Something went wrong');
                    }
                });
            }
        </script>
    <?php endif; ?>

    <div class="card mt-3">
        <div class="card-header">
            <h3>Shipping Address</h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Street:
                <?= $order->shippingAddress->street ?>
            </li>
            <li class="list-group-item">House Number:
                <?= $order->shippingAddress->housenumber ?>
            </li>
            <li class="list-group-item">Zip Code:
                <?= $order->shippingAddress->zipCode ?>
            </li>
            <li class="list-group-item">City:
                <?= $order->shippingAddress->city ?>
            </li>
        </ul>
    </div>

    <div class="card mt-5 mb-5">
        <div class="card-header">
            <h3>Order Items</h3>
        </div>
        <?php foreach ($order->orderItems as $item): ?>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item">Product ID:
                    <?= $item->productId ?>
                </li>
                <li class="list-group-item">Unit Price:
                    <?= $item->unitPrice ?>
                </li>
                <li class="list-group-item">Quantity:
                    <?= $item->quantity ?>
                </li>
                <li class="list-group-item">Status:
                    <?= $item->status->name ?>
                </li>
            </ul>
        <?php endforeach; ?>
    </div>
</div>