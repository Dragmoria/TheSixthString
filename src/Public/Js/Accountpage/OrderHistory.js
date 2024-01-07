$(document).ready(function () {
    $("#orderHistoryButton").on("click", function () {
      event.preventDefault();
      $.ajax({
        url: "/RetrievingOrderHistory",
        type: "POST",
        dataType: "json",
        success: function (response) {
          updateOrderHistoryForm(response.orders, response.Addresses)
        },
        error: function (xhr, status, error) {
        }
      });
    });
  });

  function updateOrderHistoryForm(orderHistoryData, addressData) {
    const orderHistoryContainer = document.getElementById('orderHistoryContainer');
    orderHistoryContainer.innerHTML = '';

    orderHistoryData.forEach(function (order) {
      const orderDate = new Date(order.createdOn.date);
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      const formattedDate = orderDate.toLocaleDateString('nl-NL', options);
      const finalTotal = order.orderTotal + order.orderTax;
      const searchStr = order.id + " shippingAddress";
      const addressArray = addressData[searchStr];
      const extensionHandle = addressArray.housenumberExtension;
      const orderElement = document.createElement('div');
      orderElement.classList.add('ms-5', 'me-5');


      orderElement.innerHTML = `<h6 style="color: #EFE3C4">Bestelnummer: ${order.id} | ${formattedDate}</h6>
  <br> <p6 style="color: #EFE3C4">Totaal bedrag: €${finalTotal.toLocaleString('nl-NL', { minimumFractionDigits: 2 })}</p6>
  <br> <p6 style="color: #EFE3C4">Afleveradres: </p6>
  <br> <p6 style="color: #EFE3C4">${addressArray.street} ${addressArray.housenumber}${extensionHandle}</p6>
  <br> <p6 style="color: #EFE3C4">${addressArray.zipCode}, ${addressArray.city}</p6>
  <div class="col text-end me-3">  
    <i><u style="color: #EFE3C4"><a href="#" id="${order.id}" data-number="${order.id}" class="OrderModalButton text-decoration-none" style="color: #EFE3C4">Details</a></u></i>
    ${!isDateOlderThan30Days(order.createdOn.date) ? `<a style="color: #EFE3C4"> | </a><i><u style="color: #EFE3C4"><a href="#" data-number="${order.id}" class="ReturnModalButton text-decoration-none" style="color: #EFE3C4">Retourneren</a></u></i>` : ''}
  </div>
  <div class="row justify-content-center mt-2 mb-4">
    <div class="order-divider"></div>
  </div>`;

      orderHistoryContainer.appendChild(orderElement);
    });
  }


  function isDateOlderThan30Days(dateString) {

    const inputDate = new Date(dateString);
    const currentDate = new Date();

    const timeDifference = currentDate - inputDate;
    const daysDifference = timeDifference / (1000 * 60 * 60 * 24);

    return daysDifference > 30;
  }


//-----------------------------open order details--------------------------------------
  $(document).on('click', '#orderHistoryContainer .OrderModalButton', function (event) {

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
        var ProductBody = document.getElementById('ProductsBody');
        var ProductDetails = response.Products;
        var orderItems = response.orderItems;

        ProductBody.innerHTML = '';

        $('#OrderModal .modal-title').html('Bestelnummer: ' + value1);


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
        ${isFirstIteration ? '<h5 style=color:#EFE3C4>Aantal: </h5>' : ''}
        <p6 style=color:#EFE3C4>${ProductAmount}</p6>
      </div>
<div class="text-center col-2">
        ${isFirstIteration ? '<h5 style=color:#EFE3C4>Productprijs: </h5>' : ''}
        <p6 style=color:#EFE3C4>€${detail.unitPrice.toLocaleString('nl-NL', { minimumFractionDigits: 2 })}</p6>
      </div>
      <div class="text-center col-2">
        ${isFirstIteration ? '<h5 style=color:#EFE3C4>Totaalprijs: </h5>' : ''}
        <p6 style=color:#EFE3C4>€${TotalPrice.toLocaleString('nl-NL', { minimumFractionDigits: 2 })}</p6>
      </div>
      <div class="mt-3 mb-2 Modal-order-divider"></div>
    </div>`;

          ProductBody.appendChild(ProductBodyElement);
        });
        $('#OrderModal').modal('show');
      }
    });
  });