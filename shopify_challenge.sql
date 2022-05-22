/* initialize database */ 
CREATE DATABASE shopify_challenge;
USE shopify_challenge;
/* initialize tables */
CREATE TABLE items(
	item_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    item_name VARCHAR(45) NOT NULL
);
CREATE TABLE categories(
	category_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(45) NOT NULL
);
CREATE TABLE locations(
	location_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    location_name VARCHAR(45) NOT NULL
);
CREATE TABLE location_has_item(
	location_id int,
    item_id int,
    qty int
);
CREATE TABLE category_has_item(
	category_id int,
    item_id int
);
INSERT INTO items(item_name) 
	VALUES('Cricut Explore Air 2'),
    ('Scissors'),
    ('Corner Cutter'),
    ('Paper Cutter'),
    ('Sewing Machine'),
    ('Denim Fabric'),
    ('Rotary Cutter'),
    ('Fabric Ruler'),
    ('Cutting Mat'),
    ('4x6 Canvas'),
    ('8x10 Canvas'),
    ('11x14 Canvas'),
    ('Easel'),
    ('Watercolors Palette'),
    ('Acrylic Palette'),
    ('Paint Brush Set'),
    ('Apron');
INSERT INTO categories(category_name)
	VALUES ('Card Making'),
    ('Sewing'),
    ('Painting');
INSERT INTO locations(location_name)
	VALUES('Los Angeles'),
    ('San Francisco'),
    ('New York');
/* set up joint tables with default values that can be changed with CRUD */
INSERT INTO category_has_item(category_id, item_id) VALUES
	(1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (1, 9),
    (2, 2),
    (2, 5), 
    (2, 6),
    (2, 7),
    (2, 8),
    (2, 9),
    (3, 10),
    (3, 11),
    (3, 12),
    (3, 13),
    (3, 14),
    (3, 15),
    (3, 16),
    (3, 17);
INSERT INTO location_has_item(location_id, item_id, qty) VALUES
	(1, 1, 10),
    (1, 2, 35),
    (1, 3, 30),
    (1, 4, 12),
    (1, 5, 9),
    (1, 6, 150),
    (1, 7, 29),
    (1, 8, 27),
    (1, 9, 50),
    (1, 10, 50),
    (1, 11, 50),
    (1, 12, 50),
    (1, 13, 32),
    (1, 14, 28),
    (1, 15, 36),
    (1, 16, 34),
    (1, 17, 30), /* end of LA location */
    (2, 1, 10),
    (2, 2, 35),
    (2, 3, 30),
    (2, 4, 12),
    (2, 5, 9),
    (2, 6, 150),
    (2, 7, 29),
    (2, 8, 27),
    (2, 9, 50),
    (2, 10, 50),
    (2, 11, 50),
    (2, 12, 50),
    (2, 13, 32),
    (2, 14, 28),
    (2, 15, 36),
    (2, 16, 34),
    (2, 17, 30), /* end of SF location */
    (3, 1, 10),
    (3, 2, 35),
    (3, 3, 30),
    (3, 4, 12),
    (3, 5, 9),
    (3, 6, 150),
    (3, 7, 29),
    (3, 8, 27),
    (3, 9, 50),
    (3, 10, 50),
    (3, 11, 50),
    (3, 12, 50),
    (3, 13, 32),
    (3, 14, 28),
    (3, 15, 36),
    (3, 16, 34),
    (3, 17, 30); /* end of NY location */
