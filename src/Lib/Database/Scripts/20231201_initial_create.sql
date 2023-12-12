#CREATE DATABASE thesixthstring;

CREATE TABLE thesixthstring.user(
	id int AUTO_INCREMENT NOT NULL,
	emailAddress varchar(255) NOT NULL,
	passwordHash text NOT NULL,
	role int NOT NULL,
	firstName varchar(100) NOT NULL,
	insertion varchar(50) NULL,
	lastName varchar(150) NOT NULL,
	dateOfBirth datetime NULL,
	gender int NOT NULL,
	active bit NOT NULL,
	createdOn datetime NOT NULL,
    PRIMARY KEY (id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.address(
	id int AUTO_INCREMENT NOT NULL,
	userId int NOT NULL,
	street varchar(255) NOT NULL,
	housenumber int NOT NULL,
	housenumberExtension varchar(25) NULL,
	zipCode varchar(10) NOT NULL,
	city varchar(150) NOT NULL,
	country int NOT NULL,
	active bit NOT NULL,
	type int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES user(id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.brand(
	id int AUTO_INCREMENT NOT NULL,
	name varchar(150) NOT NULL,
	description text NOT NULL,
	active bit NOT NULL,
    PRIMARY KEY (id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.category(
	id int AUTO_INCREMENT NOT NULL,
	name varchar(150) NOT NULL,
	description text NOT NULL,
	parentId int NULL,
	active bit NOT NULL,
	media text NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (parentId) REFERENCES category(id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.coupon(
	id int AUTO_INCREMENT NOT NULL,
	name varchar(150) NOT NULL,
	code varchar(50) NOT NULL,
	value decimal(18, 2) NOT NULL,
	startDate datetime NOT NULL,
	endDate datetime NULL,
	usageAmount int NOT NULL,
	maxUsageAmount int NULL,
	active bit NOT NULL,
	type int NOT NULL,
    PRIMARY KEY (id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.order(
	id int AUTO_INCREMENT NOT NULL,
	userId int NOT NULL,
	orderTotal decimal(18, 2) NOT NULL,
	orderTax decimal(18, 2) NOT NULL,
	couponId int NULL,
	shippingAddressId int NOT NULL,
	invoiceAddressId int NOT NULL,
	paymentStatus int NOT NULL,
	shippingStatus int NOT NULL,
	createdOn datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES user(id),
    FOREIGN KEY (couponId) REFERENCES coupon(id),
    FOREIGN KEY (shippingAddressId) REFERENCES address(id),
    FOREIGN KEY (invoiceAddressId) REFERENCES address(id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.product(
	id int AUTO_INCREMENT NOT NULL,
	name varchar(255) NOT NULL,
	subtitle text NOT NULL,
	description text NOT NULL,
	active bit NOT NULL,
	amountInStock int NOT NULL,
	demoAmountInStock int NOT NULL,
	unitPrice decimal(18, 2) NOT NULL,
	recommendedUnitPrice decimal(18, 2) NOT NULL,
	sku varchar(12) NOT NULL,
	brandId int NULL,
	categoryId int NULL,
	media text NULL,
	createdOn datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (brandId) REFERENCES brand(id) ON DELETE SET NULL,
    FOREIGN KEY (categoryId) REFERENCES category(id) ON DELETE SET NULL
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.orderitem(
	id int AUTO_INCREMENT NOT NULL,
	orderId int NOT NULL,
	productId int NOT NULL,
	unitPrice decimal(18, 2) NOT NULL,
	quantity int NOT NULL,
	status int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (orderId) REFERENCES `order`(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.orderpayment(
	id int AUTO_INCREMENT NOT NULL,
	orderId int NOT NULL,
	method int NOT NULL,
	paymentDate datetime NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (orderId) REFERENCES `order`(id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.paymentprovider(
	id int AUTO_INCREMENT NOT NULL,
	name varchar(100) NOT NULL,
	apiKey varchar(100) NOT NULL,
	apiSecret text NOT NULL,
	active bit NOT NULL,
    PRIMARY KEY (id)
);

#------------------------------------------------------------------------------------------------------------------------------



CREATE TABLE thesixthstring.review(
	id int AUTO_INCREMENT NOT NULL,
	rating int NOT NULL,
	title varchar(255) NOT NULL,
	content text NOT NULL,
	orderItemId int NOT NULL,
	status int NOT NULL,
	createdOn datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (orderItemId) REFERENCES orderitem(id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.shoppingcart(
	id int AUTO_INCREMENT NOT NULL,
	userId int NULL,
	sessionUserGuid varchar(36) NOT NULL,
	createdOn datetime NOT NULL,
	modifiedOn datetime NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.shoppingcartitem(
	id int AUTO_INCREMENT NOT NULL,
	shoppingCartId int NOT NULL,
	productId int NOT NULL,
	quantity int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (shoppingCartId) REFERENCES shoppingcart(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES product(id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.tryoutschedule(
	id int AUTO_INCREMENT NOT NULL,
	date datetime NOT NULL,
	productId int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (productId) REFERENCES product(id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.visitedproduct(
	id int AUTO_INCREMENT NOT NULL,
	productId int NOT NULL,
	date datetime NOT NULL,
	sessionUserGuid varchar(36) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (productId) REFERENCES product(id)
);

#------------------------------------------------------------------------------------------------------------------------------

create table resetpassword
(
    id         int auto_increment
        primary key,
    userId     int         not null,
    link       varchar(32) not null,
    validUntil datetime    not null,
    constraint reset_password_link_unique
        unique (link),
    constraint reset_password_user_id_fk
        foreign key (userId) references user (id)
);

#------------------------------------------------------------------------------------------------------------------------------