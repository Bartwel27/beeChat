-- database log

-- main db
-- users table
create table users(
  id int(11) not null primary key auto_increment,
  username varchar(20) not null,
  email varchar(50) not null,
  userid varchar(20) not null,
  status varchar(10) not null,
  password varchar(100) not null
);


-- assets db

-- contacts table 
-- created when email confirmed
create table contact(
  id int(11) not null primary key auto_increment,
  contact_username varchar(20) not null,
  contact_email varchar(50) not null,
  contact_userid varchar(20) not null,
  contact_file varchar(70) not null
);

-- inbox table
-- created when email confirmed
create table inbox(
  id int(11) not null primary key auto_increment,
  sender_username varchar(20) not null,
  sender_email varchar(50) not null,
  sender_userid varchar(20) not null,
  receiver_username varchar(20) not null,
  receiver_email varchar(20) not null,
  receiver_userid varchar(20) not null,
  message text not null
);
