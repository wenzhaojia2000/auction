CREATE TABLE "User" (
    userID SERIAL PRIMARY KEY,
    username VARCHAR(32) NOT NULL,
    -- hashes are fixed length so use char
    password CHAR(60) NOT NULL,
    email VARCHAR(254) NOT NULL,
    addressLine1 VARCHAR(50) NOT NULL,
    addressLine2 VARCHAR(50),
    city VARCHAR(50) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    phoneNo VARCHAR(20) NOT NULL,
    firstName VARCHAR(99) NOT NULL,
    lastName VARCHAR(99) NOT NULL
);

CREATE TABLE "Category" (
    categoryName VARCHAR(50) NOT NULL PRIMARY KEY
);

CREATE TABLE "Items" (
    itemID SERIAL PRIMARY KEY,
    userID INT NOT NULL REFERENCES "User"(userID),
    itemName VARCHAR(99) NOT NULL,
    itemDescription VARCHAR(5000),
    itemCondition VARCHAR(20) NOT NULL,
    -- NUMERIC(17, 2) allows numbers between negative one quadrillion and positive one quadrillion, rounded to 2 decimal places.
    reservationPrice NUMERIC(17, 2) NOT NULL,
    startingPrice NUMERIC(17, 2) NOT NULL,
    currentPrice NUMERIC(17, 2) NOT NULL,
    categoryName VARCHAR(50) NOT NULL REFERENCES "Category"(categoryName),
    listingDate TIMESTAMP NOT NULL,
    endDate TIMESTAMP NOT NULL,
    -- null for delivery price means no delivery
    deliveryPrice NUMERIC(17, 2)
);

CREATE TABLE "Sold" (
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID)
);

CREATE TABLE "Image" (
    itemID INT REFERENCES "Items"(itemID),
    itemImage VARCHAR(500)
);

CREATE TABLE "Watches" (
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID)
);

CREATE TABLE "Bid" (
    bidID SERIAL PRIMARY KEY,
    userID INT REFERENCES "User"(userID),
    itemID INT REFERENCES "Items"(itemID),
    bidPrice NUMERIC(17, 2) NOT NULL,
    bidDate DATE NOT NULL
);

CREATE TABLE "Buyer" (
    userID INT REFERENCES "User"(userID)
);

CREATE TABLE "Seller" (
    userID INT REFERENCES "User"(userID)
);