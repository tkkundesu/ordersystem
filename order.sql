drop database if exists order_system;
create database order_system default character set utf8 collate utf8_general_ci;
grant all on order_system .* to 'user'@'localhost' identified by 'password';
use order_system;

create table products (
	id int auto_increment primary key,
	productName varchar(255) not null,
	is_view tinyint(1) default 0, /* 0:view, 1:not view */
	milk tinyint(1) default 0, /* 0:none, 1:チェックボックス用意 */
	sugar tinyint(1) default 0 /* 0:noen, 1:チェックボックス用意*/
);



create table room (
	id int auto_increment primary key,
	room_name varchar(255) not null,
	is_use tinyint(1) default 0 /* 0:use, 1:not use */


);

create table owner (
	owner_login varchar(255) not null primary key,
	owner_password varchar(255) not null

);

create table drink_order (
	id int auto_increment primary key,
	room_id int not null,
	order_time timestamp,
  foreign key(room_id) references room(id)
);

create table order_detail (
	order_id int not null,
	product_id int not null,
	product_count int not null,
	milk_count int not null,
	sugar_count int not null,
	primary key(order_id, product_id),
	foreign key(product_id) references products(id),
	foreign key(order_id) references drink_order(id)
);

insert into room  values(null,'A',0);

insert into products values(null,'リンゴジュース',0,0,0);

insert into drink_order values(null,1,null);

insert into order_detail values(1,1,1,0,0);

insert into owner values('owner','pass');
