-- passwords are mockuser1 ... mockuser8
INSERT INTO "User"(userid, username, password, email, addressline1, addressline2, city, postcode, phoneno, firstname, lastname)  VALUES (1,'jgable','$2y$10$85englTuW9Ruo4lj6AnJE.lUxRkHkRrLr9c4x1F.fGydzRbgWFbga','jgable@a8.net','Harold''s Park Farm','Nazeing','London','EN9 2SF','1383702705','Joseph','Gable')
, (2,'kbrushneen','$2y$10$FylMJauejZo/OYVljfiybOIWGWAcBdgVU4fBk.qALtWIxn/4gu4WC','kbrushneen@ibm.com','6 Portormin Rd',NULL,'Dunbeath','KW6 6EF','1837080595','Kristy','Brushneen')
, (3,'lnovic','$2y$10$pQcE4pDuGpEUIr4wiluj1uL6k6Ncr/DupwyOql/WfyLHgqUaWDpKy','lnovic@clickbank.net','16C Lynchgate Grn',NULL,'Fareham','PO14 3HA','6176341689','Laird','Novic')
, (4,'rgarmey','$2y$10$c1sD507JDAymY4q62wk/A.AwKddsc0hNWoa8iBEHcXNmYjeJYHBVm','rgarmey@harvard.edu','25 St Michael''s Rd',NULL,'Paignton','TQ4 5LW','8565680556','Ruperta','Garmey')
, (5,'acalcutt','$2y$10$D59zLT/kAyk5iwP4mmCEUO72YwdyaVrJezBr8gfDhh4gypXs6mQZm','acalcutt@mysql.com','1 Walton Rd',NULL,'Washington','NE85 1AA','4315772547','Anthia','Calcutt')
, (6,'aoakshott','$2y$10$FfbKAcG3EHjjzH.Dh/uN7eEiLieoy7azATmw97K1yKJ4.lxPTl5NO','aoakshott@google.com.au','3 Hart St',NULL,'London','EC3R 7NB','5151575018','Alys','Oakshott')
, (7,'dcavolini','$2y$10$m.Y1A3WO8TYBtlZSCOGM8u7tjszcgzJ.l8acNYcYQqSDWnuEzlff.','dcavolini@tumblr.com','6 Princess Royal Terrace',NULL,'Scarborough','YO11 2SQ','6134092032','Daniela','Cavolini')
, (8,'mluto','$2y$10$7M4B8Y35g5WPlbd7dd2vKO8xMLnhZ5aRoBCJ8zGM2W3c9fJWG5VjO','mluto@paginegialle.it','30 Kingfisher Wy','Ollerton','Newark','NG22 9DL','4161104791','Meris','Luto');

ALTER SEQUENCE "User_userid_seq" RESTART WITH 9;

INSERT INTO "Buyer"(userid) VALUES (1), (3), (5), (7);

INSERT INTO "Seller"(userid) VALUES (2), (4), (6), (8);