create table "USER" ( 
    "User ID" INT not null PRIMARY KEY,
    "Username" char(20) not null,
    "Password" char(50) not null,
    "Email" char(50) not null,
    "Address Line" char(50) not null, -- change
    "City" Char(20) not NULL, -- change
    "Postcode" char(50) not null,
    "PhoneNo" Numeric(20) not null,
    "First Name" char(50) not null,
    "Last Name" char(50) not null
);

Create table category (
    "Category Name" Char(50) not NULL PRIMARY KEY
);

create table items ( 
    "Item ID" INT not NULL PRIMARY KEY,
    "User ID" INT not NULL REFERENCES "USER"("User ID"),
    "Item Name" char(50) not NULL,
    "Item Image" bytea not NULL,
    "Item Description" char(500) not NULL,
    "Item condition" char(20) not NULL,
    "reservation Price" Numeric(20) not NULL,
    "Starting Price" numeric(20) not NULL,
    "Current Price" numeric(20) not NULL,
    "Category Name" CHar(20) not NULL REFERENCES "category"("Category Name"),
    "listing Date" DATE not NULL,
    "End date" DATE not NULL,
    "Delivery Price" Numeric(20) not NULL
);


Create table watches (
    "User ID" INT REFERENCES "USER"("User ID"),
    "Item ID" INT REFERENCES "items"("Item ID")
);

Create table Bid (
    "Bid ID" INT NOT NULL PRIMARY KEY,
    "User ID" INT REFERENCES "USER"("User ID"),
    "Item ID" INT REFERENCES "items"("Item ID"),
    "Bid price" numeric (20),
    "Bid Date" DATE
);

Create table sells (
    "User ID" INT REFERENCES "USER"("User ID"),
    "Item ID" INT REFERENCES "items"("Item ID")
);

create table "Customer" (
    "User ID" INT REFERENCES "USER"("User ID")
);

create table "Seller" (
    "User ID" INT REFERENCES "USER"("User ID")
);