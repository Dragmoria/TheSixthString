#CREATE DATABASE thesixthstring;

CREATE TABLE thesixthstring.user(
	Id int AUTO_INCREMENT NOT NULL,
	EmailAddress varchar(255) NOT NULL,
	PasswordHash text NOT NULL,
	Role int NOT NULL,
	FirstName varchar(100) NOT NULL,
	Insertion varchar(50) NULL,
	LastName varchar(150) NOT NULL,
	DateOfBirth datetime NULL,
	Gender int NOT NULL,
	Active bit NOT NULL,
	CreatedOn datetime NOT NULL,
    PRIMARY KEY (Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.address(
	Id int AUTO_INCREMENT NOT NULL,
	UserId int NOT NULL,
	Street varchar(255) NOT NULL,
	Housenumber int NOT NULL,
	HousenumberExtension varchar(25) NULL,
	ZipCode varchar(10) NOT NULL,
	City varchar(150) NOT NULL,
	Country int NOT NULL,
	Active bit NOT NULL,
	Type int NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (UserId) REFERENCES user(Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.brand(
	Id int AUTO_INCREMENT NOT NULL,
	Name varchar(150) NOT NULL,
	Description text NOT NULL,
	Active bit NOT NULL,
    PRIMARY KEY (Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.category(
	Id int AUTO_INCREMENT NOT NULL,
	Name varchar(150) NOT NULL,
	Description text NOT NULL,
	ParentId int NULL,
	Active bit NOT NULL,
	Media text NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (ParentId) REFERENCES category(Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.coupon(
	Id int AUTO_INCREMENT NOT NULL,
	Name varchar(150) NOT NULL,
	Code varchar(50) NOT NULL,
	Value decimal(18, 2) NOT NULL,
	StartDate datetime NOT NULL,
	EndDate datetime NULL,
	UsageAmount int NOT NULL,
	MaxUsageAmount int NULL,
	Active bit NOT NULL,
	Type int NOT NULL,
    PRIMARY KEY (Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.order(
	Id int AUTO_INCREMENT NOT NULL,
	UserId int NOT NULL,
	OrderTotal decimal(18, 2) NOT NULL,
	OrderTax decimal(18, 2) NOT NULL,
	CouponId int NULL,
	ShippingAddressId int NOT NULL,
	InvoiceAddressId int NOT NULL,
	PaymentStatus int NOT NULL,
	ShippingStatus int NOT NULL,
	CreatedOn datetime NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (UserId) REFERENCES user(Id),
    FOREIGN KEY (CouponId) REFERENCES coupon(Id),
    FOREIGN KEY (ShippingAddressId) REFERENCES address(Id),
    FOREIGN KEY (InvoiceAddressId) REFERENCES address(Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.product(
	Id int AUTO_INCREMENT NOT NULL,
	Name varchar(255) NOT NULL,
	Subtitle text NOT NULL,
	Description text NOT NULL,
	Active bit NOT NULL,
	AmountInStock int NOT NULL,
	DemoAmountInStock int NOT NULL,
	UnitPrice decimal(18, 2) NOT NULL,
	RecommendedUnitPrice decimal(18, 2) NOT NULL,
	SKU varchar(12) NOT NULL,
	BrandId int NULL,
	CategoryId int NULL,
	Media text NULL,
	CreatedOn datetime NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (BrandId) REFERENCES brand(Id) ON DELETE SET NULL,
    FOREIGN KEY (CategoryId) REFERENCES category(Id) ON DELETE SET NULL
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.orderitem(
	Id int AUTO_INCREMENT NOT NULL,
	OrderId int NOT NULL,
	ProductId int NOT NULL,
	UnitPrice decimal(18, 2) NOT NULL,
	Quantity int NOT NULL,
	Status int NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (OrderId) REFERENCES `order`(Id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES product(Id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.orderpayment(
	Id int AUTO_INCREMENT NOT NULL,
	OrderId int NOT NULL,
	Method int NOT NULL,
	PaymentDate datetime NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (OrderId) REFERENCES `order`(Id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.paymentprovider(
	Id int AUTO_INCREMENT NOT NULL,
	Name varchar(100) NOT NULL,
	ApiKey varchar(100) NOT NULL,
	ApiSecret text NOT NULL,
	Active bit NOT NULL,
    PRIMARY KEY (Id)
);

#------------------------------------------------------------------------------------------------------------------------------



CREATE TABLE thesixthstring.review(
	Id int AUTO_INCREMENT NOT NULL,
	Rating int NOT NULL,
	Title varchar(255) NOT NULL,
	Content text NOT NULL,
	OrderItemId int NOT NULL,
	Status int NOT NULL,
	CreatedOn datetime NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (OrderItemId) REFERENCES orderitem(Id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.shoppingcart(
	Id int AUTO_INCREMENT NOT NULL,
	UserId int NULL,
	SessionUserGuid varchar(36) NOT NULL,
	CreatedOn datetime NOT NULL,
	ModifiedOn datetime NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (UserId) REFERENCES user(Id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.shoppingcartitem(
	Id int AUTO_INCREMENT NOT NULL,
	ShoppingCartId int NOT NULL,
	ProductId int NOT NULL,
	Quantity int NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (ShoppingCartId) REFERENCES shoppingcart(Id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES product(Id) ON UPDATE CASCADE ON DELETE CASCADE
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.tryoutschedule(
	Id int AUTO_INCREMENT NOT NULL,
	Date datetime NOT NULL,
	ProductId int NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (ProductId) REFERENCES product(Id)
);

#------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE thesixthstring.visitedproduct(
	Id int AUTO_INCREMENT NOT NULL,
	ProductId int NOT NULL,
	Date datetime NOT NULL,
	SessionUserGuid varchar(36) NOT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (ProductId) REFERENCES product(Id)
);

#------------------------------------------------------------------------------------------------------------------------------