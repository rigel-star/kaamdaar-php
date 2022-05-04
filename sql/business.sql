DROP TABLE IF EXISTS painting_businesses;

create table business_category(
	bc_id int primary key auto_increment,
	bc_name varchar(50) not null
) ENGINE=INNODB;

insert into business_category(bc_name) values("Painter"), ("Carpenter"), ("Computer Repair"), ("Plumber");

CREATE TABLE IF NOT EXISTS painting_businesses(
	b_id INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	b_name VARCHAR(255) NOT NULL,
	b_phone VARCHAR(20) NOT NULL,
	b_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	b_location VARCHAR(255) NOT NULL,
	b_loc_latlong VARCHAR(20) NOT NULL,
	u_id INT(4) NOT NULL,
	FOREIGN KEY(u_id) REFERENCES users(u_id)
)ENGINE=INNODB;

INSERT INTO painting_businesses(b_name, b_phone, b_date, b_location, b_loc_latlong, u_id)
VALUES("Ramesh Solutions Pvt. Ltd.", "9819187362", DEFAULT, "Sankhamul, Planning Lane 9, Lalitpur", "27.6853, 85.3317", 1);

INSERT INTO painting_businesses(b_name, b_phone, b_date, b_location, b_loc_latlong, u_id)
VALUES("Pragati Solutions Pvt. Ltd.", "9803993178", DEFAULT, "Pulchowk, Lalitpur", "27.6853, 85.3317", 2);

create table business_profile(
	bp_id int not null primary key auto_increment,
	bp_name varchar(100) not null,
	u_id int not null,
	foreign key(u_id) references users(u_id)
)ENGINE=INNODB;

insert into business_profile(bp_name, u_id)
	value("Pragati Solutions Pvt. Ltd.", 1);

create table plumber_businesses(
	pb_id int not null primary key auto_increment,
	bp_id int not null,
	foreign key(bp_id) references business_profile(bp_id)
)ENGINE=INNODB;

insert into plumber_businesses (
	bp_id
) values (
	1,
);


create table carpenter_businesses(
    pb_id int not null primary key auto_increment,
    bp_id int not null,
    foreign key(bp_id) references business_profile(bp_id)
)ENGINE=INNODB;