insert into product (name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn)
VALUES ('Testproduct', 'Dit is een testproduct', 'Lorem ipsum...', 1, 0, 0, 100, 110, 'ABC123', '2023-12-08');

insert into user (emailAddress, passwordHash, role, firstName, lastName, gender, active, createdOn)
VALUES ('admin@thesixthstring.store', 'dnewfeiwfhwoidhewiopdjxwio0', 0, 'Admin', 'De Admin', 0, 1, '2023-12-08');

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 1, '1234AA', 'Amsterdam', 0, 1, 0);

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 2, '1234AB', 'Amsterdam', 0, 1, 1);

insert into `order` (userId, orderTotal, orderTax, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn)
VALUES (1, 100, 21, 1, 2, 0, 0, '2023-12-08');

insert into orderitem (orderId, productId, unitPrice, quantity, status)
VALUES (1, 1, 100, 1, 0);

insert into review (rating, title, content, orderItemId, status, createdOn)
VALUES (4, 'Testreview', 'Lorem ipsum...', 1, 0, '2023-12-08');