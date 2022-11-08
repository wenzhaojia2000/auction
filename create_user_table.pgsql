create table "USER" ( 
    UserID integer PRIMARY KEY,
    Username char(20) not null,
    Email char(50) not null,
    Address char(50) not null,
    Password char(50) not null,
    PhoneNo Numeric(20) not null,
    FirstName char(50) not null,
    LastName char(50) not null
);