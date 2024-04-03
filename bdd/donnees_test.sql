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
("pilote2@mail.com", "Pilote2", "PILOTE2", "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm");  -- mdp: test

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
("etudiant1@mail.com", "Etudiant1", "ETUDIANT1", 1, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm"),  -- mdp: test
("etudiant2@mail.com", "Etudiant2", "ETUDIANT2", 2, "$2y$10$SQ9m3VeCIOh4on6QFqkHVOa89carPJWm/rcH7jh5YII1GpbDBVZpm");  -- mdp: test

-- Adresses
INSERT INTO Address (streetNumber, streetName, idCity) VALUES
(10, "Rue de la Paix", 1),
(20, "Rue du Commerce", 2);

-- Offres de stage
INSERT INTO InternshipOffer (skills, title, description, remuneration, offerDate, numberOfPlaces, duration, minor, pictureURL, idAddress, idCompany) VALUES 
("Java, SQL", "Développeur Java", "Développement d'applications Java", 1000.0, "2022-10-01", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg", 1, 1),
("C++, Python", "Développeur C++", "Développement d'applications C++", 1200.0, "2022-10-02", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 2, 2),
("Web Development", "Web Developer", "Building responsive websites", 800.0, "2022-10-03", 3, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/4/4f/Icon-Vue.js-Logo.svg", 1, 1),
("Data Analysis", "Data Analyst", "Analyzing large datasets", 900.0, "2022-10-04", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/3/38/Jupyter_logo.svg", 2, 2),
("Mobile App Development", "Mobile App Developer", "Creating native mobile apps", 1100.0, "2022-10-05", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/8/82/Android_logo_2019.svg", 1, 1),
("UI/UX Design", "UI/UX Designer", "Designing user-friendly interfaces", 1000.0, "2022-10-06", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/9/91/Adobe_XD_CC_icon.svg", 2, 2),
("Cybersecurity", "Cybersecurity Analyst", "Protecting systems from cyber threats", 1200.0, "2022-10-07", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/6/6b/Icon-Cybersecurity-Logo.svg", 1, 1),
("Machine Learning", "Machine Learning Engineer", "Building intelligent systems", 1500.0, "2022-10-08", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/0/05/Scikit_learn_logo_small.svg", 2, 2),
("Cloud Computing", "Cloud Engineer", "Managing cloud infrastructure", 1300.0, "2022-10-09", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/2/2d/Amazon_Web_Services_Logo.svg", 1, 1),
("Blockchain", "Blockchain Developer", "Implementing decentralized solutions", 1400.0, "2022-10-10", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/1/18/Ethereum_logo.svg", 2, 2),
("Full Stack Development", "Full Stack Developer", "Building end-to-end web applications", 1200.0, "2022-10-11", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg", 1, 1),
("Artificial Intelligence", "AI Engineer", "Creating intelligent systems", 1600.0, "2022-10-12", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/1/1b/PyTorch_logo_black.svg", 2, 2),
("Game Development", "Game Developer", "Designing and coding games", 1000.0, "2022-10-13", 3, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/9/9c/Unity_Technologies_logo.svg", 1, 1),
("DevOps", "DevOps Engineer", "Streamlining software development", 1100.0, "2022-10-14", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/0/05/Devops-toolchain.svg", 2, 2),
("Big Data", "Big Data Engineer", "Processing and analyzing large datasets", 1300.0, "2022-10-15", 1, 6, "INFO", "https://upload.wikimedia.org/wikipedia/commons/3/38/Apache_Hadoop_logo.svg", 1, 1),
("Robotics", "Robotics Engineer", "Building intelligent robots", 1500.0, "2022-10-16", 2, 6, "GENE", "https://upload.wikimedia.org/wikipedia/commons/7/7e/ROS_logo.svg", 2, 2);

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
