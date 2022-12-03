CREATE TABLE "User" (
    userID SERIAL PRIMARY KEY,
    username CHAR(20) NOT NULL,
    password CHAR(60) NOT NULL,
    email CHAR(50) NOT NULL,
    addressLine1 CHAR(50) NOT NULL,
    addressLine2 CHAR(20),
    city CHAR(20) NOT NULL,
    postcode CHAR(20) NOT NULL,
    phoneNo NUMERIC(20) NOT NULL,
    firstName CHAR(50) NOT NULL,
    lastName CHAR(50) NOT NULL
);

CREATE TABLE "Category" (
    categoryName CHAR(50) NOT NULL PRIMARY KEY
);

CREATE TABLE "Items" (
    itemID SERIAL PRIMARY KEY,
    userID INT NOT NULL REFERENCES "User"(userID),
    itemName CHAR(50) NOT NULL,
    itemImage CHAR(500) NOT NULL,
    itemDescription CHAR(5000) NOT NULL,
    itemCondition CHAR(20) NOT NULL,
    reservationPrice NUMERIC(20) NOT NULL,
    startingPrice NUMERIC(20) NOT NULL,
    currentPrice NUMERIC(20) NOT NULL,
    categoryName CHAR(50) NOT NULL REFERENCES "Category"(categoryName),
    listingDate TIMESTAMP NOT NULL,
    endDate TIMESTAMP NOT NULL,
    deliveryPrice NUMERIC(20) NOT NULL
);

CREATE TABLE "Sells" (
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID)
);

CREATE TABLE "Watches" (
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID)
);

CREATE TABLE "Bid" (
    bidID SERIAL PRIMARY KEY,
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID),
    bidPrice numeric (20),
    bidDate DATE
);
CREATE TABLE "Buyer" (
    userID INT REFERENCES "User"(userID)
);

CREATE TABLE "Seller" (
    userID INT REFERENCES "User"(userID)
);


