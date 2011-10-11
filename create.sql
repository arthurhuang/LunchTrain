BEGIN;

DROP TABLE IF EXISTS network;
DROP TABLE IF EXISTS user_in_train;
DROP TABLE IF EXISTS train_to_loc;
DROP TABLE IF EXISTS user_send_msg;
DROP TABLE IF EXISTS user_in_net;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS trains; 
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS locations;


-- store all the users who have registered.
CREATE TABLE IF NOT EXISTS users(
        email varchar(50) not null, 
        userid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        firstname varchar(15) NOT NULL,
        lastname varchar(15) NOT NULL, 
        password varchar(64) NOT NULL
) ENGINE=InnoDB;

-- store all the trains which have been created
CREATE TABLE IF NOT EXISTS trains (
        trainid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        spaceAvailable INT,
        transportType VARCHAR(20) NOT NULL,
        trainDescription VARCHAR(255),
        meetingPlace CHAR(255) NOT NULL,
        departureTime INT NOT NULL,
        private BOOLEAN NOT NULL default 0,
	trainName varchar(50)
) ENGINE=InnoDB;

-- stores network information
CREATE TABLE IF NOT EXISTS network (
        networkName VARCHAR(30),
        netid INT NOT NULL AUTO_INCREMENT PRIMARY KEY
) ENGINE=InnoDB;

-- stores location information
CREATE TABLE IF NOT EXISTS locations (
        locid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        street VARCHAR(50),
        city VARCHAR (50),
        state VARCHAR(50),
        houseNum VARCHAR(50),
        moreinfo VARCHAR(1000)
) ENGINE=InnoDB;

-- stores messages
CREATE TABLE IF NOT EXISTS messages(
        msgID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        msgText VARCHAR(1000) NOT NULL,
        source INT NOT NULL,
        dest INT NOT NULL,
        FOREIGN KEY (source) REFERENCES users(userid),
        FOREIGN KEY (dest) REFERENCES users(userid)
) ENGINE=InnoDB;

-- stores relationship information between users and trains
CREATE TABLE IF NOT EXISTS user_in_train (
        userid INT NOT NULL,
        FOREIGN KEY (userid) REFERENCES users(userid),
        trainid INT NOT NULL,
        FOREIGN KEY (trainid) REFERENCES trains(trainid),
        creator BOOLEAN default 0,
        attending BOOLEAN default 0
) ENGINE=InnoDB;

-- relationship between trains and location
CREATE TABLE IF NOT EXISTS train_to_loc (
        trainid INT NOT NULL PRIMARY KEY,
        FOREIGN KEY (trainid) REFERENCES trains(trainid),
        locid INT NOT NULL,
        FOREIGN KEY(locid) REFERENCES locations(locid)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user_send_msg (
        userid INT NOT NULL,
        msgid INT NOT NULL,
        FOREIGN KEY (userid) REFERENCES users(userid),
        FOREIGN KEY (msgid) REFERENCES messages(msgID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user_in_net (
        userid INT NOT NULL,
        netid INT NOT NULL,
        FOREIGN KEY (userid) REFERENCES users(userid),
        FOREIGN KEY (netid) REFERENCES network(netid)
) ENGINE=InnoDB;

COMMIT;