create table tasks
(
    id        int unsigned auto_increment
        primary key,
    name      varchar(100)         not null,
    email     varchar(100)         not null,
    task      text                 not null,
    status    tinyint(1) default 0 not null,
    performed tinyint(1) default 0 not null
)
    collate = utf8mb4_unicode_ci;
