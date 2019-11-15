drop database if exists cinemapp;
CREATE DATABASE IF NOT EXISTS CINEMAPP;
USE CINEMAPP;

CREATE TABLE IF NOT EXISTS cinemas(
id int AUTO_INCREMENT,
cinema_name varchar(50),
address varchar(50),
active boolean,
CONSTRAINT pk_cinemas PRIMARY KEY (id));

CREATE TABLE IF NOT EXISTS movies(
id int auto_increment,
title varchar(50),
duration int(3), 
original_language varchar(15),
overview varchar(900),
release_date varchar(10),
adult boolean,
poster_path varchar(50),
constraint unq_title UNIQUE(title),
constraint pk_movies PRIMARY KEY (id));

CREATE TABLE IF NOT EXISTS genres(
id int auto_increment,
genre_name varchar(50),
constraint pk_genres PRIMARY KEY (id),
CONSTRAINT unq_genres UNIQUE (genre_name));


CREATE TABLE IF NOT EXISTS genres_by_movies(
id_movie int,
id_genre int, 
constraint pk_genres_by_movies_id_movie_id_genre PRIMARY KEY (id_movie, id_genre),
constraint fk_genres_by_movies_id_movie FOREIGN KEY (id_movie) REFERENCES movies(id) ON DELETE CASCADE,
constraint fk_genres_by_movies_id_genre FOREIGN KEY (id_genre) REFERENCES genres(id) ON DELETE CASCADE);


CREATE TABLE IF NOT EXISTS users(
id int AUTO_INCREMENT,
password varchar(12),
email varchar(30),
firstname varchar(30),
lastname varchar(30),
dni int,
constraint pk_users PRIMARY KEY (id),
CONSTRAINT unq_email UNIQUE (email),
CONSTRAINT unq_dni UNIQUE (dni));

CREATE TABLE IF NOT EXISTS languages(
id int AUTO_INCREMENT,
name_language varchar(18),
CONSTRAINT pk_language PRIMARY KEY(id),
CONSTRAINT unq_name_language UNIQUE(name_language));

CREATE TABLE IF NOT EXISTS theaters(
id int AUTO_INCREMENT,
theater_name varchar(45),
id_cinema int,
active boolean,
ticket_value float,
capacity int,
CONSTRAINT pk_theater PRIMARY KEY(id),
CONSTRAINT unq_theater_name_id_cinema UNIQUE (theater_name,id_cinema),
CONSTRAINT fk_id_cinema_theaters FOREIGN KEY (id_cinema) REFERENCES cinemas(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS showtimes(
id int AUTO_INCREMENT,
id_language int,
id_movie int,
id_theater int,
view_date date,
hour time,
subtitles boolean,
active boolean,
ticketAvaliable int,
CONSTRAINT pk_showtimes PRIMARY KEY (id),
constraint fk_id_language_showtimes FOREIGN KEY (id_language) REFERENCES languages(id),
CONSTRAINT fk_id_movie_showtimes FOREIGN KEY (id_movie) REFERENCES movies(id) ON DELETE CASCADE,
CONSTRAINT fk_id_theater_showtimes FOREIGN KEY (id_theater) REFERENCES theaters(id) ON DELETE CASCADE);

CREATE TABLE IF NOT EXISTS credit_cards(
id int AUTO_INCREMENT,
cc_number varchar(16),
id_user int,
CONSTRAINT pk_credit_cards PRIMARY KEY (id),
CONSTRAINT fk_id_user_cc FOREIGN KEY (id_user) REFERENCES users(id));

CREATE TABLE IF NOT EXISTS purchases(
id int AUTO_INCREMENT,
purchase_date date,
hour time,
ticketsAmount int,
total int,
id_user int,
id_cc varchar(16),
CONSTRAINT pk_ticket PRIMARY KEY (id),
CONSTRAINT fk_id_user_purchase FOREIGN KEY(id_user) REFERENCES users (id),
CONSTRAINT fk_id_cc_purchase FOREIGN KEY(id_cc) REFERENCES credit_cards (id));



CREATE TABLE IF NOT EXISTS tickets(
id int AUTO_INCREMENT,
id_showtime int,
id_purchase int,
CONSTRAINT pk_ticket PRIMARY KEY(id),
CONSTRAINT fk_id_showtime FOREIGN KEY (id_showtime) REFERENCES showtimes(id) ON DELETE RESTRICT,
CONSTRAINT fk_purchase FOREIGN KEY (id_purchase) REFERENCES purchases(id)ON DELETE RESTRICT);


insert into cinemas (cinema_name, address, active) values ('Aldrey', 'Vieja Terminal', true)
																				 ,('Ambassador', 'Peatonal', true)
                                                                                 ,('Gallegos', 'La Rioja', true)
                                                                                 ,('Diagonal', 'Diagonal Pueyrredón', true);

insert into languages(name_language) values ('English'), ('Spanish'), ('French'), ('Italian'), ('Russian');
insert into theaters(theater_name, id_cinema, active, ticket_value, capacity) values('sala 1', 1, true, 200, 300)
																									,('sala 2', 1, true, 350, 200)
                                                                                                    ,('sala Atmos', 2, true, 200, 400)
                                                                                                    ,('sala 1 ', 3, true, 400, 200)
                                                                                                    ,('sala 2', 4, true, 500, 150);
/*insert into showtimes(id_language, id_movie,id_theater,view_date,hour,subtitles,active,ticketAvaliable) values(5, 3, 1, '2019-11-02', '11:50', false, true, 400);*/
/*
select now();

select * from movies;

select * from cinemas;

select * from theaters;
*/
/*select * from theaters WHERE theaters.id_cinema=1;*/

/*drop database cinemapp;*/

INSERT INTO showtimes (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) 
VALUES (5,2,5,100,'2019-11-20','10:00',0,1);
INSERT INTO showtimes (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) 
VALUES (5,2,5,100,'2019-11-20','14:00',0,1);
INSERT INTO showtimes (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) 
VALUES (5,2,5,100,'2019-11-20','18:00',0,1);
INSERT INTO showtimes (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) 
VALUES (5,2,5,100,'2019-11-20','22:00',0,1);
INSERT INTO showtimes (id_movie, id_theater,id_language,ticketAvaliable, view_date,hour,subtitles,active) 
VALUES (5,2,5,100,'2019-11-20','01:00',0,1);