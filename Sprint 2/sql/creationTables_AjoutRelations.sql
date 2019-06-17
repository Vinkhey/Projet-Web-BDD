/*  Kevin Teixeira
	 20.05.2019
    Ce scipt permet de créer la tables intermédiaire "locations" ainsi que ses relations
*/

USE snows;

/*renomme la colonne id pour une meilleures compréhension et pour éviter la confusion*/
alter table snows
rename column id to idSnows;

/*Même chose que pour le cas ci-dessus*/
alter table users
rename column id to idUsers;

/*Création de la table location stockants les locations de l'utilisateur
Dans ce cas, la table location et une table intermédiaire*/
CREATE TABLE IF NOT EXISTS locations (
    idLocations int NOT NULL,
    idSnows int(11) NOT NULL,
    idUsers int(10) NOT NULL,
    dateDebut date NOT NULL,
    dateFin date NOT NULL
);

alter table locations 
add Quantité int;

/*Crée un index référençant la table "Users" pour créer plusieurs clés étrangères*/
CREATE INDEX idx_idUsers ON  locations(idUsers);

Alter table locations
add primary key (idLocations);

/*Création de la clé étrangère de la table snows*/
ALTER table locations
add constraint FK_Snows_Users
foreign key locations(idSnows) references snows(idSnows);


/*Création de la clé étrangère de la table users*/
ALTER table locations
add constraint FK_Users_Snows
foreign key locations(idUsers) references users(idUsers);