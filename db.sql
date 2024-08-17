 CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2),
    image VARCHAR(255),
    categorie_id INT
);
 INSERT INTO produits (nom, description, prix, image, categorie_id) VALUES
('Poulet rôti', 'Poulet rôti doré et croustillant', 16.99, 'd.png', 1),
('Ailes de poulet BBQ', 'Ailes de poulet marinées et grillées', 8.99, 'c.png', 2),
('Canard laqué', 'Canard cuit lentement et laqué', 29.99, 'a.png', 1),
('Nuggets de poulet', 'Nuggets de poulet panés.', 6.99, 'b.png', 3),
('Poule pondeuse', 'Ponde plusieurs oeufs par jour', 30.00, 'e.png', NULL),
('Poule pondeuse trop vieille', 'Ponde plusieurs oeufs par jour', 30.00, 'f.png', NULL);
 CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    email VARCHAR(255),
    mot_de_passe VARCHAR(255)
    role VARCHAR(20);
);
 INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe,role) VALUES
('yameogo', 'kiswndddc', 'yameoogildas89@gmail.com', 'S2y$10SByU6QpALI3KXl'admin),
('yam', 'gil', 'yameoogildas89@gmail.com', '123456'user),
('ali', 'veru', 'ali@gmail.com', 'veru'user);
('fatou','mara','fatou@gmail.com','12345',admin);
('oue','camara','oue@gmai.com','oue',admin);
('kadi','camara','kadi@gmai.com','1235',user);

CREATE TABLE panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produit_id INT,
    nom VARCHAR(255),
    description TEXT,
    prix DECIMAL(10, 2),
    image VARCHAR(255),
    categorie VARCHAR(255),
    quantite INT,
    user_id INT
);
INSERT INTO panier (produit_id, nom, description, prix, image, categorie, quantite, user_id) VALUES
(1, 'Vache ', ' ', 75.50, ' c.jpeg', '2 ', 4,1 ,)
(2, 'Mouton', ' ', 115.65, 'a.jpeg', ' ', 2, NULL),
(3, 'Chevre', ' ', 65.99, 'd.jpeg', ' ', 1, NULL);
(4, 'Poule pondeuse', ' ', 30.99, 'b.jpeg', ' ', 3, NULL);
(5, 'lapin', ' ', 65.99, 'e.jpeg', ' ', 4, NULL);
(6, 'Poule Ameraucana', ' ', 45.55, 'k.jpeg', ' ', 3, NULL);
 CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);
