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