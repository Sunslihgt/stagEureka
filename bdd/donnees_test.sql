USE stageureka_mysql;


-- Administrateur
INSERT INTO Administrator (email, name, firstName, password) VALUE ("admin@admin.com", "Admin", "Admin", "$2y$10$OaVu0RUmidSkEUhVWOWfbe0CipbcjTE.gzQoyoYolhpyS1XnT9pn2");

-- Entreprises
INSERT INTO Company (nameCompany, activityAera, applicationAmount) VALUES
("Entreprise1", "ESN", 3),
("Entreprise2", "Banque", 10);

-- Pilotes
INSERT INTO Pilot (email, name, firstName, password) VALUES 
("pilote1@mail.com", "Pilote1", "PILOTE1", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),  -- mdp: test
("pilote2@mail.com", "Pilote2", "PILOTE2", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote3@mail.com", "Pilote3", "PILOTE3", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote4@mail.com", "Pilote4", "PILOTE4", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote5@mail.com", "Pilote5", "PILOTE5", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote6@mail.com", "Pilote6", "PILOTE6", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote7@mail.com", "Pilote7", "PILOTE7", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote8@mail.com", "Pilote8", "PILOTE8", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote9@mail.com", "Pilote9", "PILOTE9", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote10@mail.com", "Pilote10", "PILOTE10", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote11@mail.com", "Pilote11", "PILOTE11", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("pilote12@mail.com", "Pilote12", "PILOTE12", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm");  -- mdp: test

-- Villes
INSERT INTO City (cityName, addressCode) VALUES
("Paris", "75000"),
("Lyon", "69000");

-- Classes
INSERT INTO Class (className, yearClass, idCity, idPilot) VALUES
("A2 INFO", 2022, 1, 1),
("A3 FISA GENE", 2023, 2, 2);

-- Étudiants
INSERT INTO Student (email, name, firstName, idClass, password) VALUES 
("etudiant1@mail.com", "Etudiant1", "ETUDIANT1", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),  -- mdp: test
("etudiant2@mail.com", "Etudiant2", "ETUDIANT2", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant3@mail.com", "Etudiant3", "ETUDIANT3", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant4@mail.com", "Etudiant4", "ETUDIANT4", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant5@mail.com", "Etudiant5", "ETUDIANT5", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant6@mail.com", "Etudiant6", "ETUDIANT6", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant7@mail.com", "Etudiant7", "ETUDIANT7", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant8@mail.com", "Etudiant8", "ETUDIANT8", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant9@mail.com", "Etudiant9", "ETUDIANT9", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant10@mail.com", "Etudiant10", "ETUDIANT10", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant11@mail.com", "Etudiant11", "ETUDIANT11", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),
("etudiant12@mail.com", "Etudiant12", "ETUDIANT12", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm");  -- mdp: test

-- Adresses
INSERT INTO Address (streetNumber, streetName, idCity) VALUES
(10, "Rue de la Paix", 1),
(20, "Rue du Commerce", 2);

-- Offres de stage
INSERT INTO InternshipOffer (skills, title, description, remuneration, offerDate, numberOfPlaces, duration, minor, pictureURL, idAddress, idCompany) VALUES 
("Java, SQL", "Développeur Java", "Développement d'applications Java", 1000.0, "2022-10-01", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg", 1, 1),
("C++, Python", "Développeur C++", "Développement d'applications C++", 1200.0, "2022-10-02", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Web Development", "Web Developer", "Building responsive websites", 800.0, "2022-10-03", 3, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Data Analysis", "Data Analyst", "Analyzing large datasets", 900.0, "2022-10-04", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Mobile App Development", "Mobile App Developer", "Creating native mobile apps", 1100.0, "2022-10-05", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("UI/UX Design", "UI/UX Designer", "Designing user-friendly interfaces", 1000.0, "2022-10-06", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Cybersecurity", "Cybersecurity Analyst", "Protecting systems from cyber threats", 1200.0, "2022-10-07", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Machine Learning", "Machine Learning Engineer", "Building intelligent systems", 1500.0, "2022-10-08", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/0/05/Scikit_learn_logo_small.svg", 2, 2),
("Cloud Computing", "Cloud Engineer", "Managing cloud infrastructure", 1300.0, "2022-10-09", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Blockchain", "Blockchain Developer", "Implementing decentralized solutions", 1400.0, "2022-10-10", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Full Stack Development", "Full Stack Developer", "Building end-to-end web applications", 1200.0, "2022-10-11", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Artificial Intelligence", "AI Engineer", "Creating intelligent systems", 1600.0, "2022-10-12", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Game Development", "Game Developer", "Designing and coding games", 1000.0, "2022-10-13", 3, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("DevOps", "DevOps Engineer", "Streamlining software development", 1100.0, "2022-10-14", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/0/05/Devops-toolchain.svg", 2, 2),
("Big Data", "Big Data Engineer", "Processing and analyzing large datasets", 1300.0, "2022-10-15", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Robotics", "Robotics Engineer", "Building intelligent robots", 1500.0, "2022-10-16", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2);

-- Entreprises installées
INSERT INTO is_settle (idCompany, idAddress) VALUES
(1, 1),
(2, 2);

-- Candidatures
-- INSERT INTO Candidacy (idStudent, idInternshipOffer, CV, coverLetter) VALUES
-- (1, 1, "url_cv", "Lettre de motivation..."),
-- (2, 2, "url_cv", "Lettre de motivation...");

-- Provenance des candidatures
-- INSERT INTO came_from (idInternshipOffer, idCandidacy) VALUES
-- (1, 1),
-- (2, 2);

-- Notes des étudiants
INSERT INTO grade (idStudent, idCompany, studentGrade) VALUES
(1, 1, 5),
(2, 2, 4);

-- Évaluations des offres de stage
INSERT INTO rate (idPilot, idCompany, pilotGrade) VALUES
(1, 1, 1),
(2, 2, 2);

-- Wishlist des étudiants
INSERT INTO wishlist (idStudent, idInternshipOffer) VALUES
(1, 1),
(2, 2);
