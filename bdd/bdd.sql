USE stageureka_mysql;

-- Suppression des tables existantes
DROP TABLE IF EXISTS came_from;
DROP TABLE IF EXISTS is_settle;
DROP TABLE IF EXISTS rate;
DROP TABLE IF EXISTS grade;
DROP TABLE IF EXISTS wishlist;
DROP TABLE IF EXISTS Candidacy;
DROP TABLE IF EXISTS InternshipOffer;
DROP TABLE IF EXISTS Student;
DROP TABLE IF EXISTS Class;
DROP TABLE IF EXISTS Address;
DROP TABLE IF EXISTS City;
DROP TABLE IF EXISTS Pilot;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Company;

-- Creation de la BDD
CREATE TABLE Company (
   idCompany INT NOT NULL AUTO_INCREMENT,
   nameCompany VARCHAR(50) NOT NULL,
   activityAera VARCHAR(50) NOT NULL,
   applicationAmount INT NOT NULL DEFAULT 0,
   visible TINYINT(1) NOT NULL DEFAULT 1,
   PRIMARY KEY(idCompany)
);

CREATE TABLE Administrator(
   idAdministrator INT NOT NULL AUTO_INCREMENT,
   email VARCHAR(320) NOT NULL,
   name VARCHAR(50) NOT NULL,
   firstName VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   PRIMARY KEY(idAdministrator)
);

CREATE TABLE Pilot(
   idPilot INT NOT NULL AUTO_INCREMENT,
   email VARCHAR(320) NOT NULL,
   name VARCHAR(50) NOT NULL,
   firstName VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   PRIMARY KEY(idPilot)
);

CREATE TABLE City(
   idCity INT NOT NULL AUTO_INCREMENT,
   cityName VARCHAR(50),
   addressCode VARCHAR(10),
   PRIMARY KEY(idCity)
);

CREATE TABLE Class(
   idClass INT NOT NULL AUTO_INCREMENT,
   className VARCHAR(50),
   yearClass INT NOT NULL,
   idCity INT NOT NULL,
   idPilot INT NOT NULL,
   PRIMARY KEY(idClass),
   FOREIGN KEY(idCity) REFERENCES City(idCity),
   FOREIGN KEY(idPilot) REFERENCES Pilot(idPilot)
);

CREATE TABLE Student(
   idStudent INT NOT NULL AUTO_INCREMENT,
   email VARCHAR(320) NOT NULL,
   name VARCHAR(50) NOT NULL,
   firstName VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   idClass INT NOT NULL,
   PRIMARY KEY(idStudent),
   FOREIGN KEY(idClass) REFERENCES Class(idClass)
);

CREATE TABLE Candidacy(
   idCandidacy INT NOT NULL AUTO_INCREMENT,
   CV BLOB,
   coverLetter TEXT,
   idStudent INT NOT NULL,
   PRIMARY KEY(idCandidacy),
   FOREIGN KEY(idStudent) REFERENCES Student(idStudent)
);

CREATE TABLE Address(
   idAddress INT NOT NULL AUTO_INCREMENT,
   streetNumber INT NOT NULL,
   streetName VARCHAR(50) NOT NULL,
   idCity INT NOT NULL,
   PRIMARY KEY(idAddress),
   FOREIGN KEY(idCity) REFERENCES City(idCity)
);

CREATE TABLE InternshipOffer(
   idInternshipOffer INT NOT NULL AUTO_INCREMENT,
   skills VARCHAR(258) NOT NULL,
   title VARCHAR(50) NOT NULL,
   description VARCHAR(255) NOT NULL,
   remuneration VARCHAR(50) NOT NULL,
   offerDate DATE NOT NULL,
   numberOfPlaces INT NOT NULL,
   duration INT NOT NULL,
   minor INT NOT NULL,
--    gene TINYINT(1) NOT NULL DEFAULT 0,
--    S3E TINYINT(1) NOT NULL DEFAULT 0,
--    BTP TINYINT(1) NOT NULL DEFAULT 0,
--    info TINYINT(1) NOT NULL DEFAULT 0,
   pictureURL TEXT,
   idAddress INT NOT NULL,
   idCompany INT NOT NULL,
   PRIMARY KEY(idInternshipOffer),
   FOREIGN KEY(idAddress) REFERENCES Address(idAddress),
   FOREIGN KEY(idCompany) REFERENCES Company(idCompany)
);

CREATE TABLE wishlist(
   idStudent INT NOT NULL,
   idInternshipOffer INT NOT NULL,
   PRIMARY KEY(idStudent, idInternshipOffer),
   FOREIGN KEY(idStudent) REFERENCES Student(idStudent),
   FOREIGN KEY(idInternshipOffer) REFERENCES InternshipOffer(idInternshipOffer)
);

CREATE TABLE grade(
   idStudent INT NOT NULL,
   idCompany INT NOT NULL,
   studentGrade DECIMAL(15,2) NOT NULL,
   PRIMARY KEY(idStudent, idCompany),
   FOREIGN KEY(idStudent) REFERENCES Student(idStudent),
   FOREIGN KEY(idCompany) REFERENCES Company(idCompany)
);

CREATE TABLE rate(
   idPilot INT NOT NULL,
   idCompany INT NOT NULL,
   pilotGrade VARCHAR(50),
   PRIMARY KEY(idPilot, idCompany),
   FOREIGN KEY(idPilot) REFERENCES Pilot(idPilot),
   FOREIGN KEY(idCompany) REFERENCES Company(idCompany)
);

CREATE TABLE is_settle(
   idCompany INT NOT NULL,
   idAddress INT NOT NULL,
   PRIMARY KEY(idCompany, idAddress),
   FOREIGN KEY(idCompany) REFERENCES Company(idCompany),
   FOREIGN KEY(idAddress) REFERENCES Address(idAddress)
);

CREATE TABLE came_from(
   idInternshipOffer INT NOT NULL,
   idCandidacy INT NOT NULL,
   PRIMARY KEY(idInternshipOffer, idCandidacy),
   FOREIGN KEY(idInternshipOffer) REFERENCES InternshipOffer(idInternshipOffer),
   FOREIGN KEY(idCandidacy) REFERENCES Candidacy(idCandidacy)
);
