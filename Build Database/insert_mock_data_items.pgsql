-- v: Item 1 --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (1, 2, E'2022 BMC TwoStroke AL 20 Inch Wheel Kids Bike', E'The BMC Twostroke AL 20" is the perfect first pedal bike to get your little ones out on two wheels!\nWith its chunky 2.4" wide tyres and wide range 1x8 drivetrain, this bike is the ideal platform for getting kids aged 5-8 out and riding, no matter the terrain.\n\nFeatures:\nIncredibly lightweight aluminium frame allowing for easy transport and use.\nWide 2.4 inch wide tyres to provide endless traction and ride damping.\nHydraulic disc brakes with short reach levers, perfect for tiny hands!\n1x8 SRAM wide range drivetrain allowing the smallest riders to tackle the biggest hills.', 'new', 300.00, 200.00, 245.00, 'Cars, Motorcycles & Vehicles', '2022-12-01 15:08:35', '2022-12-22 00:00:00', 0.00);

INSERT INTO "Image"(itemid, itemimage) VALUES (1, '4e4458b106fa7157206b192292732078.png');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (1, 1, 1, 210.00, '2022-12-02')
,(13, 7, 1, 220.00, '2022-12-04')
,(14, 1, 1, 220.01, '2022-12-04')
,(15, 7, 1, 245.00, '2022-12-06');

-- ^: Item 1  v: Item 2: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (2, 2, 'Mountfield MTF98MSD Petrol Ride On Lawn Mower 98cm', E'The Mountfield MTF98MSD offers the perfect solution for those who do not wish to collect grass clippings. Mulching grass is a great feature as it saves so much time and can be more than 30% quicker than conventional methods as there is no stopping work to drive to the tip to empty the collector; this also results in a significant fuel saving. Mulching grass allows the clippings to be recycled, improving the soil as they decompose forming a natural fertiliser high in potash and nitrogen. You will notice a marked improvement in your grass as this fertiliser takes effect over the course of the cutting season. You may well ask ''Will I see the mulched grass?'' and the answer is ''No!'' Mulched clippings are blown down into the turf and are not noticeable provided the grass is cut regularly and not on the lowest setting. Powered by a single cylinder 352cc Stiga engine, the MTF98MSD has a manual transmission with 5 forward gears plus reverse. It is fitted with a 98cm/38" working width cutter deck with side discharge or mulch options and height of cut is easy to adjust with 7 settings from 25mm to 80mm. Other quality features include electromagnetic blade engagement, a tow bar, head lights and a wash facility on the deck.\n\nEngine\nEngine Brand: Stiga.\nEngine Type: ST350.\nEngine Capacity: 352cc.\nFuel Tank Capacity: 6 Litres.\n\nDrive/Steering\nTransmission: 5 Forward & 1 Reverse.\nWheels: Front 13" Rear 18".\n\nCutting\nBlade Engagement: Electronic Switch.\nCutting Width: 98cm.\nCutting Heights: 25-80mm (7 Positions).\n\nGeneral\nLawn Size: Up to 2.5 acre / 10000m2.\nBattery Charger: Not Included.\nWeight: 165kg.', 'new', 1900.00, 1600.00, 1713.99, 'Cars, Motorcycles & Vehicles', '2022-12-01 17:34:07', '2022-12-23 00:00:00', 0.00);

INSERT INTO "Image"(itemid, itemimage) VALUES (2, '2a579af45ee8613fb44fd4075dc9e63b.png')
,(2, '97a3147e29962abe8fb5b8edc045c36d.png')
,(2, '7ade7ca739a8f77bf67a7d6ab6bf1038.png');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (2, 3, 2, 1615.00, '2022-12-02')
,(3, 7, 2, 1700.00, '2022-12-02')
,(4, 3, 2, 1713.99, '2022-12-06');

-- ^: Item 2  v: Item 3: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (3, 4, 'Inflatable smiling banana costume', E'It says what it says in the title.', 'used', 3.00, 3.00, 18.50, 'Clothes, Shoes & Accessories', '2022-12-04 09:13:44', '2022-12-18 20:00:00', NULL);

INSERT INTO "Image"(itemid, itemimage) VALUES (3, '0b8925bf79e844dadf7d82b752445278.jpg');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (5, 3, 3, 3.50, '2022-12-04')
,(6, 1, 3, 5.00, '2022-12-04')
,(7, 7, 3, 6.99, '2022-12-04')
,(8, 5, 3, 8.00, '2022-12-05')
,(9, 7, 3, 11.00, '2022-12-06')
,(10, 1, 3, 13.50, '2022-12-08')
,(11, 3, 3, 16.99, '2022-12-09')
,(12, 7, 3, 18.50, '2022-12-09');

-- ^: Item 3  v: Item 4: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (4, 4, 'Orange adidas t-shirt', E'Medium size. Wore it a few times but mainly just collected dust in the wardrobe.', 'used', 8.00, 8.00, 10.00, 'Clothes, Shoes & Accessories', '2022-12-06 13:13:44', '2022-12-20 10:00:00', NULL);

INSERT INTO "Image"(itemid, itemimage) VALUES (4, '9a0edf50b9abcd95f02e5cda6f79139d.jpg')
,(4, '1743cf5e30beeb7a549d36f11c165308.jpg');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (16, 3, 4, 9.00, '2022-12-04')
,(17, 1, 4, 10.00, '2022-12-04');

-- ^: Item 4  v: Item 5: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (5, 6, 'Butterfly Ear Hook Drop Dangle Earrings', E'  ', 'used', 7.00, 5.50, 7.30, 'Jewellery & Watches', '2022-12-07 04:18:01', '2022-12-30 15:00:00', 10.00);

INSERT INTO "Image"(itemid, itemimage) VALUES (5, '12b8d860df39ac033b17052be1de7d2a.jpg')
,(5, '55d661927f2e2e9fe53975aeff4dc9b9.jpg');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (18, 5, 5, 7.30, '2022-12-04');

-- ^: Item 5  v: Item 6: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (6, 6, 'Rolex Submariner', E'From 2003, box and papers included. 16610 LN.', 'used', 10000.00, 9000.00, 9000.00, 'Jewellery & Watches', '2022-12-08 01:11:24', '2022-12-31 15:00:00', 10.00);

INSERT INTO "Image"(itemid, itemimage) VALUES (6, 'ea65063e3595b75b5e7bf5caab9859d2.jpg');

-- ^: Item 6  v: Item 7: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (7, 8, 'Aptamil Advanced 3 Formula Toddler Milk Powder 1-3 Years 800g', E'Aptamil Profutura Growing Up Milk is now called Aptamil Advanced Toddler Milk. Suitable in combination with breastfeeding. Vitamins A, B2, C, Omega-3 LCP; Vitamin D to support the normal function of the immune system; Iron to support normal cognitive development; Calcium for normal growth and development of bone. Palm Oil Free Oil Blend\n\nAptamil® Advanced Toddler Milk, our most advanced formulation* (*contains iron to support normal cognitive development) is a tailored* drink for toddlers.\n\nThe beginning of your baby''s life is a special and beautiful time. Our passionate team of more than 500 scientists and experts are devoted to bringing you and your toddler the latest scientific discoveries our research has to offer. Inspired by 50 years of early life nutrition research we have gone a step further to develop Aptamil® Advanced Toddler Milk, a tailored milk drink for toddlers, which is also suitable in combination with breastfeeding.\n\nSupporting you on your toddler''s journey - Just 2x150ml beakers each day of Aptamil® Advanced Toddler Milk is one way to help support your toddler''s nutrient intake in combination with a varied, balanced diet.\n\nOur unique blend of GOS/FOS and 2''FL**\nNo artificial preservatives‡\n** Our blend of Galacto- and Fructo-oligosaccharides with 2''-Fucosyllactose.\n‡ As required by the legislation\n\nSuitable for Toddlers aged 1-3 Years.\nFor feeding instructions see back of pack. Contains Fish, Milks and Soya.', 'new', 12.00, 10.00, 12.00, 'Baby', '2022-12-09 15:30:22', '2022-12-22 00:00:00', 10.00); 

INSERT INTO "Image"(itemid, itemimage) VALUES (7, 'b4e8f677239b0303de3d526016619ca4.png')
,(7, 'bf28b16faa4d1abc96100828f385d2e3.png');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (19, 3, 7, 11.00, '2022-12-10')
,(20, 5, 7, 12.00, '2022-12-10');

-- ^: Item 7  v: Item 8: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (8, 8, 'Santa Cruz Skateboard Obscure Hand Large 8.25"', E'Featuring all-new wider shapes for easy foot placement and shorter wheelbases for easy turning with a sizing guide hangtag that makes buying a new entry-level complete straightforward for beginners of any age or gender.\n\nHigh-Quality Components:\nDeck: Lightweight, super strong 7-ply birch construction\nTrucks: Strong, lightweight cast aluminum trucks w/ either 85a cushions (super-micro, micro, & mini) or 90a cushions (mid-large sizes) for easy turning.\nWheels: Smooth riding, durable wheels w/ either 83a hardness (super-micro, micro, & mini) or 95a hardness (mid-large sizes) high-rebound urethane.\nGrip tape: High quality professional grade grit and adhesive.\nBearings: Durable high speed precision steel bearings with oil lubricant for easy rolling.\n\nComplete Size: 8.25in x 31.5in\nDeck Concave: Medium\nDeck Construction: 7-ply\nDeck Length (Inches): 31.5\nDeck Noselength (Inches): 6.80\nDeck Taillength (Inches): 6.50\nDeck Wheelbase (Inches): 14.0\nDeck Width (Inches): 8.25', 'new', 55.00, 30.00, 45.00, 'Sporting Goods', '2022-12-09 18:11:03', '2022-12-24 02:00:00', 10.00);

INSERT INTO "Image"(itemid, itemimage) VALUES (8, '1c82e2271ad7dfdf973c5d0ed2f82306.jpg')
,(8, '8862e96fa6fa9df4ebc4228c47725c60.jpg');

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (21, 1, 8, 55.00, '2022-12-09')
,(22, 3, 8, 55.00, '2022-12-09')
,(23, 1, 8, 55.00, '2022-12-09')
,(24, 7, 8, 55.00, '2022-12-10')
,(25, 1, 8, 55.00, '2022-12-10');

-- ^: Item 8  v: Item 9: --

INSERT INTO "Items"(itemid, userid, itemname, itemdescription, itemcondition, reservationprice, startingprice, currentprice, categoryname, listingdate, enddate, deliveryprice) VALUES (9, 6, 'iPhone 13 Pro', E'It''s definitely one of mine', 'used', 900.00, 900.00, 1030.00, 'Mobile Phones & Communication', '2022-12-10 07:11:16', '2023-01-01 23:00:00', 0.00);

INSERT INTO "Bid"(bidid, userid, itemid, bidprice, biddate) VALUES (26, 5, 9, 910.00, '2022-12-10')
,(27, 1, 9, 920.00, '2022-12-10')
,(28, 5, 9, 940.00, '2022-12-10')
,(29, 1, 9, 940.30, '2022-12-10')
,(30, 5, 9, 970.00, '2022-12-10')
,(31, 1, 9, 970.01, '2022-12-10')
,(32, 5, 9, 1000.00, '2022-12-10')
,(33, 1, 9, 1030.00, '2022-12-10');

-- ^: Item 9  v: Correct sequence values --

ALTER SEQUENCE "Bid_bidid_seq" RESTART WITH 34;
ALTER SEQUENCE "Items_itemid_seq" RESTART WITH 10;