insert into category (name, description, parentId, active, media)
VALUES ('Gitaar', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', null, 1, '{"thumbnail":{"title": "Test thumbnail","url": "https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Elektrische gitaar', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1, '{"thumbnail":{"title": "Test thumbnail","url": "https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"video":null,"secondaryImages":[]}');

insert into category (name, description, parentId, active, media)
VALUES ('Basgitaar', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1, 1, '{"thumbnail":{"title": "Test thumbnail","url": "https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"video":null,"secondaryImages":[]}');

##

insert into brand(name, description, active)
values ('Yamaha', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1);

insert into brand(name, description, active)
values ('Fender', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 1);

##

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (1, 'Yamaha Pacifica 012 II White elektrische gitaar', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultricies euismod nunc, vel tincidunt erat viverra eu. Mauris aliquet lectus sed justo vestibulum tincidunt. Phasellus auctor posuere ligula a vehicula. Integer ultrices tempus quam ut dictum. In dignissim orci et blandit efficitur. Curabitur fermentum sapien augue, ac sodales nunc venenatis in. Fusce nec lorem et ipsum aliquet mollis id at mi. Integer vel porta leo, sit amet accumsan tellus. Quisque facilisis ligula nisi, vitae fermentum dolor sagittis et. Mauris eu imperdiet orci. Nunc turpis orci, efficitur vel venenatis vitae, feugiat eu odio. Pellentesque at consequat dolor. Morbi et convallis dui. Phasellus euismod justo eu enim scelerisque tristique. In sit amet tristique eros.', 1, 100, 0, 100, 110, 'YP000001', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"video":{"title":"Test video","url":"https://www.youtube.com/embed/oc0m3v4Wlwg?si=eMOEWvHMJMVWqsIh"},"secondaryImages":[{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"}]}', 2);

insert into product (brandId, name, subtitle, description, active, amountInStock, demoAmountInStock, unitPrice, recommendedUnitPrice, sku, createdOn, media, categoryId)
VALUES (2, 'Fender Player Jazz Bass Polar White PF', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultricies euismod nunc, vel tincidunt erat viverra eu. Mauris aliquet lectus sed justo vestibulum tincidunt. Phasellus auctor posuere ligula a vehicula. Integer ultrices tempus quam ut dictum. In dignissim orci et blandit efficitur. Curabitur fermentum sapien augue, ac sodales nunc venenatis in. Fusce nec lorem et ipsum aliquet mollis id at mi. Integer vel porta leo, sit amet accumsan tellus. Quisque facilisis ligula nisi, vitae fermentum dolor sagittis et. Mauris eu imperdiet orci. Nunc turpis orci, efficitur vel venenatis vitae, feugiat eu odio. Pellentesque at consequat dolor. Morbi et convallis dui. Phasellus euismod justo eu enim scelerisque tristique. In sit amet tristique eros.', 1, 100, 0, 100, 110, 'FP000002', '2023-12-08', '{"thumbnail":{"title": "Test thumbnail","url": "https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"mainImage":{"title":"Test main image","url":"https://images.unsplash.com/photo-1556449895-a33c9dba33dd"},"video":{"title":"Test video","url":"https://www.youtube.com/embed/oc0m3v4Wlwg?si=eMOEWvHMJMVWqsIh"},"secondaryImages":[{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1558098329-a11cff621064"},{"title":"Test thumbnail","url":"https://images.unsplash.com/photo-1550291652-6ea9114a47b1"}]}', 3);

##

insert into user (emailAddress, passwordHash, role, firstName, lastName, gender, active, createdOn)
VALUES ('admin@thesixthstring.store', '$2y$10$UXVWpnsLzqbOuSbZ2XEk.uff33oLtLLZVKGtYfH1cMEGbB/yxEIay', 0, 'Admin', 'De Admin', 0, 1, '2023-12-08');

##

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 1, '1234AA', 'Amsterdam', 0, 1, 0);

insert into address (userId, street, housenumber, zipCode, city, country, active, type)
VALUES (1, 'Stationsstraat', 2, '1234AB', 'Amsterdam', 0, 1, 1);

##

insert into `order` (userId, orderTotal, orderTax, shippingAddressId, invoiceAddressId, paymentStatus, shippingStatus, createdOn)
VALUES (1, 100, 21, 1, 2, 0, 0, '2023-12-08');

##

insert into orderitem (orderId, productId, unitPrice, quantity, status)
VALUES (1, 1, 100, 1, 0);

##

insert into review (rating, title, content, orderItemId, status, createdOn)
VALUES (4, 'Testreview', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultricies euismod nunc, vel tincidunt erat viverra eu. Mauris aliquet lectus sed justo vestibulum tincidunt. Phasellus auctor posuere ligula a vehicula. Integer ultrices tempus quam ut dictum. In dignissim orci et blandit efficitur. Curabitur fermentum sapien augue, ac sodales nunc venenatis in. Fusce nec lorem et ipsum aliquet mollis id at mi. Integer vel porta leo, sit amet accumsan tellus. Quisque facilisis ligula nisi, vitae fermentum dolor sagittis et. Mauris eu imperdiet orci. Nunc turpis orci, efficitur vel venenatis vitae, feugiat eu odio. Pellentesque at consequat dolor. Morbi et convallis dui. Phasellus euismod justo eu enim scelerisque tristique. In sit amet tristique eros.', 1, 1, '2023-12-08');

##

insert into coupon (name, code, value, startDate, active, usageAmount, type) values ('test', 'test123', 50, '2023-12-30', 1, 0, 0);

##

insert into paymentprovider (name, apiKey, apiSecret, active) values ('mollie_test', 'pfl_n9bVYJvoSS', 'test_H5R3c6ek3QypnQsNw3kCGmPgGr8WPT', 1)