CREATE TABLE submissionform( id int AUTO_INCREMENT PRIMARY KEY, Title VARCHAR(50), 
                            Latitude VARCHAR(50), Longitude VARCHAR(50), Description VARCHAR(50), Rating FLOAT, imgAddress VARCHAR(100));


CREATE TABLE reviewform (reviewID int AUTO_INCREMENT PRIMARY KEY, id int, review VARCHAR(50), Rating FLOAT);
