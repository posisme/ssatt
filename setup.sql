-- this table will hold the attendance for each date
-- the individ field is the foreign key to the indiv table
CREATE TABLE `attendance` (
  `attid` int(11) NOT NULL AUTO_INCREMENT,
  `attdate` date DEFAULT NULL,
  `individ` int(11) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`attid`);

-- this table will identify children and give a gradyear`
-- the individ field is the foreign key to the indiv table
 CREATE TABLE `children` (
  `childid` int(11) NOT NULL AUTO_INCREMENT,
  `individ` int(11) DEFAULT NULL,
  `gradyear` int(11) DEFAULT NULL,
  PRIMARY KEY (`childid`);

-- this table places individuals into Sunday school classes
-- the ssid is the foreign key in the ssclass table
-- the atttype is either "teacher", "helper", "monitor", "largegroup", or "student"
-- the individ field is the foreigh key to the indiv table
 CREATE TABLE `classlist` (
  `classlistid` int(11) NOT NULL AUTO_INCREMENT,
  `ssid` int(11) DEFAULT NULL,
  `atttype` varchar(20) DEFAULT NULL,
  `individ` int(11) DEFAULT NULL,
  PRIMARY KEY (`classlistid`);

-- this table is the basis for individuals. 
-- individ is a foreign key in many tables
CREATE TABLE `indiv` (
  `individ` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `bdate` date DEFAULT NULL,
  PRIMARY KEY (`individ`);

-- this table identifies the sunday school classes per school year
 CREATE TABLE `ssclass` (
  `ssid` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(60) DEFAULT NULL,
  `ssyear` int(11) DEFAULT NULL,
  PRIMARY KEY (`ssid`);