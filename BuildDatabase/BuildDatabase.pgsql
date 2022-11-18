CREATE DATABASE auction;

create table "User" ( 
    "userID" INT not null PRIMARY KEY,
    "username" char(20) not null,
    "password" char(50) not null,
    "email" char(50) not null,
    "addressID" INT not null,
    "phoneNo" Numeric(20) not null,
    "firstName" char(50) not null,
    "lastName" char(50) not null
);

Create table "Sells" (
    "userID" INT REFERENCES "User"(userID),
    "itemID" INT REFERENCES "Items"(itemID)
);

create table "Watches" (
    "userID" INT REFERENCES "User"(User ID),
    "itemID" INT REFERENCES "Items"(Item ID)
);

create table "BID" (
    "Bid ID" INT not NULL PRIMARY KEY,
    "User ID" INT REFERENCES "USER"("User ID"),
    "Item ID" INT REFERENCES "ITEMS"("Item ID"),
    "Bid Price" numeric (20),
    "Bid Date" DATE
);

create table "ITEMS" ( 
    "Item ID" INT not NULL PRIMARY KEY,
    "User ID" INT not NULL REFERENCES "USER"("User ID"),
    "Item Name" char(50) not NULL,
    "Item Image" bytea not NULL,
    "Item Description" char(500) not NULL,
    "Item Condition" char(20) not NULL,
    "Reservation Price" Numeric(20) not NULL,
    "Starting Price" numeric(20) not NULL,
    "Current Price" numeric(20) not NULL,
    "Category Name" char(20) not NULL REFERENCES "CATEGORY"("Category Name"),
    "Listing Date" DATE not NULL,
    "End Date" DATE not NULL,
    "Delivery Price" Numeric(20) not NULL
);

create table "CATEGORY" (
    "Category Name" Char(50) not NULL PRIMARY KEY
);

create table "CUSTOMER_ADDRESS" (
    "User ID" INT REFERENCES "USER"("User ID"),
    "Address ID" INT REFERENCES "ADDRESS"("Address ID")
); 

create table "ADDRESS" (
    "Address ID" INT not null, 
    "Address Line 1" char(50) not null, 
    "Address Line 2" char(20) not null, 
    "City" char(20) not null, 
    "Postcode" char(20) not null
); 

create table "BUYER" (
    "User ID" INT REFERENCES "USER"("User ID")
);

create table "SELLER" (
    "User ID" INT REFERENCES "USER"("User ID")
);
