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