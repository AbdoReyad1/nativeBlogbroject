create schema if not exists blog;
use blog;
create table if not exists users(
   
   id int primary key auto_increment,
   name varchar(255) not null ,
   email varchar(255) not null unique ,
   password varchar(45) not null ,
   phone varchar(15) unique,
   created_at timestamp default current_timestamp,
   updated_at timestamp default current_timestamp
);
create table if not exists posts(
id int primary key auto_increment,
title varchar(255) not null ,
content text ,
image varchar(255),
user_id int ,

constraint fk_user_id_users
foreign key (user_id)
references users(id) 
on delete cascade
on update cascade
);
create table if not exists comments(

id int primary key auto_increment,
comment text not null,
created_at timestamp default current_timestamp,
updated_at timestamp default current_timestamp,
post_id int ,
user_id int,
constraint fk_post_id_post
foreign key (post_id)
references posts(id) 
on delete cascade
on update cascade,

constraint fk_user_id_comments_users
foreign key (user_id)
references users(id) 
on delete cascade
on update cascade

);

use blog;
alter table users
add column role enum('subscriber','admin') default 'subscriber' after phone;

alter table users 
drop column role;

alter table users
add column password varchar(255) not null after email;

alter table users 
drop column password;

INSERT INTO USERS (name,email,password,phone)
           VALUES ('Abdo' , 'abdo@gmail.com' , '123456' , '01032527529');
           
           
           
           
