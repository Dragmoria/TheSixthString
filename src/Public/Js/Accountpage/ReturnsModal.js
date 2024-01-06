$(document).on('click', '#orderHistoryContainer .ReturnModalButton', function (event) {
    event.preventDefault();

    var additionalData = {
      Order: $(this).data('number')
    };

    var Data = $.param(additionalData);
    $.ajax({
      url: '/GetOrderOverview',
      method: 'POST',
      data: Data,
      dataType: 'json',
      success: function (response) {
        var value1 = response.orderId;
        var ProductBody = document.getElementById('ReturnProductsBody');
        var ProductDetails = response.Products;
        var orderItems = response.orderItems;

        ProductBody.innerHTML = '';

        $('#ReturnOrderModal .modal-title').html('Retourneren bestelnummer: ' + value1);

        ProductDetails.forEach(function (detail, index) {
          const ProductBodyElement = document.createElement('div');
          let ProductAmount = 0;
          orderItems.forEach(function (orderItem) {
            if (detail.id === orderItem.productId) {
              ProductAmount = orderItem.quantity;
            }
          });

          var TotalPrice = detail.unitPrice * ProductAmount;

          const isFirstIteration = index === 0;

          ProductBodyElement.innerHTML =
            `<div class="row">
              <div class="text-center col-2 me-5">
                ${isFirstIteration ? '<h5 style=color:#EFE3C4>Productnaam: </h5>' : ''}
                <a style="text-decoration: none;color:#EFE3C4" href="/product/${detail.id}">${detail.name}</a>
              </div>
              <div class="text-center col-2 me-3">
                ${isFirstIteration ? '<h5 style=color:#EFE3C4>Barcode: </h5>' : ''}
                <p6 style=color:#EFE3C4>${detail.sku}</p6>
              </div>
              <div class="text-center col-2 me-3">
                ${isFirstIteration ? '<h5 style="color: #EFE3C4;">Aantal: </h5>' : ''}
                ${ProductAmount > 1 ? generateSelectOptions(ProductAmount) : `<p6 style="color: #EFE3C4;">${ProductAmount}</p6>`}
              </div>
              <div class="text-center col-2">
                ${isFirstIteration ? '<h5 style=color:#EFE3C4>Productprijs: </h5>' : ''}
                <p6 style=color:#EFE3C4>€${TotalPrice}</p6>
              </div>
              <div class="justify-content-center text-center col-2">
              ${isFirstIteration ? '<h5 style=color:#EFE3C4>Retourneren? </h5>' : ''}
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              </div>
              <div class="mt-3 mb-2 Modal-order-divider"></div>
              </div>`;

          ProductBody.appendChild(ProductBodyElement);
        });

        // Show the modal
        $('#ReturnOrderModal').modal('show');
      }
    });
  });

  function generateSelectOptions(maxValue) {
    const options = Array.from({ length: maxValue }, (_, index) => index + 1);
    const selectOptions = options.map(option => `<option value="${option}">${option}</option>`).join('');
    return `<select>${selectOptions}</select>`;
  }