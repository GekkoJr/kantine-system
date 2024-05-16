<?php
include ("../api/DB.php");

$conn->query("
create table if not exists users
(
    id              int auto_increment,
    email           varchar(255) not null unique,
    token           int          null,
    token_timestamp int          null,
    role            varchar(255) not null,
    constraint users_pk
        primary key (id)
);
");

$conn->query("
create table if not exists kategorier
(
    id  int auto_increment,
    name varchar(255) not null unique,
    constraint kategorier_pk
        primary key (id)
);
");

$conn->query("
create table if not exists varer 
(
        id int auto_increment,
        navn varchar(255) not null,
        pris int not null,
        beskrivelse varchar(255),
        allergi varchar(255),
        kategori int not null,
    constraint varer_pk
        primary key (id),
    constraint varer_fk
        foreign key (kategori) references kategorier(id)
)
");

$conn->query("
create table if not exists bestillinger
(
    id int auto_increment,
    bruker_id int not null,
    total_pris int not null, 
    time int not null,
    constraint bestillinger_pk
        primary key (id),
    constraint bbestillinger_fk
        foreign key (bruker_id) references users(id)
)
");

$conn->query("
create table if not exists vare_bestilling 
(
    id int auto_increment,
    vare_id int not null,
    bestilling_id int not null,
    antall int not null,
    constraint shit_key 
        primary key (id),
    constraint vare_fk
        foreign key (vare_id) references varer(id),
    constraint bestilling_fk
        foreign key (bestilling_id) references bestillinger(id)
);
");