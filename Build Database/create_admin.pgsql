-- example password to be used. since this is on github you should use a different one.
CREATE USER auctionadmin 
WITH PASSWORD 'adminpassword';

GRANT ALL PRIVILEGES 
ON ALL TABLES IN SCHEMA public
TO auctionadmin;

GRANT USAGE, SELECT
ON ALL SEQUENCES
IN SCHEMA public TO auctionadmin;