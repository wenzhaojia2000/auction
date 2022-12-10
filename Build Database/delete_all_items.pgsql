-- removes the database's link to the images, but not the images themselves
DELETE FROM "Image";
DELETE FROM "Sold";
DELETE FROM "Bid";
DELETE FROM "Watches";
DELETE FROM "Items";

ALTER SEQUENCE "Bid_bidid_seq" RESTART WITH 1;
ALTER SEQUENCE "Items_itemid_seq" RESTART WITH 1;