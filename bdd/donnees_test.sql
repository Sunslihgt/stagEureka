USE stageureka_mysql;


-- Administrateur
INSERT INTO Administrator (email, name, firstName, password) VALUE ("admin@admin.com", "Admin", "Admin", "$2y$10$OaVu0RUmidSkEUhVWOWfbe0CipbcjTE.gzQoyoYolhpyS1XnT9pn2");

-- Entreprises
INSERT INTO Company (nameCompany, activityAera, applicationAmount) VALUES
("Entreprise1", "ESN", 3),
("Entreprise2", "Banque", 10);

-- Pilotes
INSERT INTO Pilot (email, name, firstName, password) VALUES 
("pilote1@mail.com", "Pilote1", "PILOTE1", "$2y$10$Ra/KY78SYjb0om9fFOxI6.jQ03YPdxgKoTc05GBS6cqC6jqFcPCbG"),  -- mdp: test
("pilote2@mail.com", "Pilote2", "PILOTE2", "$2y$10$Ra/KY78SYjb0om9fFOxI6.jQ03YPdxgKoTc05GBS6cqC6jqFcPCbG");  -- mdp: test

-- Villes
INSERT INTO City (cityName, addressCode) VALUES
("Paris", "75000"),
("Lyon", "69000");

-- Classes
INSERT INTO Class (className, yearClass, idCity, idPilot) VALUES
("INFO", 2022, 1, 1),
("BTP", 2023, 2, 2);

-- Étudiants
INSERT INTO Student (email, name, firstName, idClass, password) VALUES 
("etudiant1@mail.com", "Etudiant1", "ETUDIANT1", 1, "$2y$10$Ra/KY78SYjb0om9fFOxI6.jQ03YPdxgKoTc05GBS6cqC6jqFcPCbG"),  -- mdp: test
("etudiant2@mail.com", "Etudiant2", "ETUDIANT2", 2, "$2y$10$Ra/KY78SYjb0om9fFOxI6.jQ03YPdxgKoTc05GBS6cqC6jqFcPCbG");  -- mdp: test

-- Adresses
INSERT INTO Address (streetNumber, streetName, idCity) VALUES
(10, "Rue de la Paix", 1),
(20, "Rue du Commerce", 2);

-- Offres de stage
INSERT INTO InternshipOffer (skills, title, description, remuneration, offerDate, numberOfPlaces, duration, minor, pictureURL, idAddress, idCompany) VALUES 
("Java, SQL", "Développeur Java", "Développement d'applications Java", "1000€/mois", "2022-01-01", 2, 6, 18, "url_image", 1, 1),
("C++, Python", "Développeur C++", "Développement d'applications C++", "1200€/mois", "2022-01-02", 1, 6, 18, "url_image", 2, 2);

-- Entreprises installées
INSERT INTO is_settle (idCompany, idAddress) VALUES
(1, 1),
(2, 2);

-- Candidatures
INSERT INTO Candidacy (CV, coverLetter, idStudent) VALUES
("url_cv", "Lettre de motivation", 1),
("url_cv", "Lettre de motivation", 2);

-- Provenance des candidatures
INSERT INTO came_from (idInternshipOffer, idCandidacy) VALUES
(1, 1),
(2, 2);

-- Notes des étudiants
INSERT INTO grade (idStudent, idCompany, studentGrade) VALUES
(1, 1, 5),
(2, 2, 4);

-- Évaluations des offres de stage
INSERT INTO rate (idPilot, idCompany, pilotGrade) VALUES
(1, 1, 1),
(2, 2, 2);
