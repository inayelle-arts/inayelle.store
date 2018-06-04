DROP DATABASE IF EXISTS `inayelle_store_db`;

CREATE DATABASE `inayelle_store_db`;

USE inayelle_store_db;

CREATE TABLE product_types
(
	id   INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO product_types (name)
VALUES ('Tuxedo'), ('Shoes'), ('Sweater'), ('Watch'), ('T-shirt'), ('Glasses'), ('Underwear');

CREATE TABLE brands
(
	id          INT PRIMARY KEY AUTO_INCREMENT,
	name        VARCHAR(255) NOT NULL UNIQUE,
	description VARCHAR(255)    DEFAULT 'No description'
);

INSERT INTO brands (name, description)
VALUES
	('Victoria`s Secret', 'World famous underwear manufacturer'),
	('Polaroid', '#1 glasses in world'),
	('Domenica', 'Italy style'),
	('Golfstream', 'Outerwear at top quality'),
	('Lyle & Scott', 'Scotland old mark'),
	('Hackett', 'Genuine quintessence of English style'),
	('OXXFORD CLOTHES', 'Probably, the most expensive tuxedos in the world'),
	('Nike', 'Just do it'),
	('Adidas', 'Impossible is nothing'),
	('Rolex', 'Quality & prestige'),
	('Patek Philippe', 'Luxury on your hand'),
	('Jabong', 'Pick&Buy');

CREATE TABLE user_permissions
(
	id   INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(20) NOT NULL UNIQUE
);

INSERT INTO user_permissions (name) VALUES
	('common'),
	('verified'),
	('moderator'),
	('administrator');

CREATE TABLE users
(
	id            INT PRIMARY KEY AUTO_INCREMENT,
	email         VARCHAR(255) NOT NULL UNIQUE,
	password_hash VARCHAR(255) NOT NULL,
	verify_code   VARCHAR(255)    DEFAULT NULL,
	reset_code    VARCHAR(255)    DEFAULT NULL,
	permission_id INT             DEFAULT 1,
	FOREIGN KEY (permission_id) REFERENCES user_permissions (id)
);

CREATE TABLE sizes
(
	id          INT PRIMARY KEY AUTO_INCREMENT,
	name        VARCHAR(255) NOT NULL UNIQUE,
	description TEXT(2000)   NOT NULL
);

INSERT INTO sizes (name, description) VALUES
	('XXL', 'Extra-extra large'),
	('XL', 'Extra large'),
	('L', 'Large'),
	('M', 'Medium'),
	('S', 'Small'),
	('XS', 'Extra-small');

CREATE TABLE products
(
	id          INT PRIMARY KEY AUTO_INCREMENT,
	name        VARCHAR(255) NOT NULL UNIQUE,
	description TEXT(2000)   NOT NULL,
	cost        INT UNSIGNED NOT NULL,
	type_id     INT          NOT NULL,
	in_stock    BOOL         NOT NULL,
	discount    INT          NOT NULL,
	size_id     INT          NOT NULL,
	brand_id    INT          NOT NULL,
	color       VARCHAR(100) NOT NULL,
	FOREIGN KEY (type_id) REFERENCES product_types (id),
	FOREIGN KEY (size_id) REFERENCES sizes (id),
	FOREIGN KEY (brand_id) REFERENCES brands (id)
);

CREATE TABLE images_storage
(
	id            INT PRIMARY KEY AUTO_INCREMENT,
	product_id    INT        NOT NULL,
	path          TEXT(2000) NOT NULL,
	primary_image BOOL            DEFAULT FALSE,
	FOREIGN KEY (product_id) REFERENCES products (id)
);

CREATE TABLE order_status
(
	id   INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO order_status (name) VALUES
	('delivered'),
	('onway'),
	('pending');

CREATE TABLE shipping_type
(
	id   INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO shipping_type (name) VALUES
	('pickup'),
	('courier'),
	('post');

CREATE TABLE shippings
(
	id            INT PRIMARY KEY AUTO_INCREMENT,
	address       TEXT(2000) NOT NULL,
	shipping_type INT        NOT NULL
);

CREATE TABLE orders
(
	id           INT PRIMARY KEY AUTO_INCREMENT,
	user_id      INT NOT NULL,
	order_date   DATETIME        DEFAULT CURRENT_TIMESTAMP,
	status_id    INT NOT NULL,
	shipping_id  INT NOT NULL,
	user_comment VARCHAR(255)    DEFAULT 'No user comments',
	FOREIGN KEY (user_id) REFERENCES users (id),
	FOREIGN KEY (status_id) REFERENCES order_status (id),
	FOREIGN KEY (shipping_id) REFERENCES shippings (id)
);

CREATE TABLE ordered_products
(
	id         INT PRIMARY KEY AUTO_INCREMENT,
	product_id INT          NOT NULL,
	order_id   INT          NOT NULL,
	count      INT UNSIGNED NOT NULL,
	total_cost INT UNSIGNED NOT NULL,
	FOREIGN KEY (product_id) REFERENCES products (id),
	FOREIGN KEY (order_id) REFERENCES orders (id)
);

INSERT INTO products (name, description, cost, type_id, in_stock, discount, size_id, brand_id, color)
VALUES ('Satin Slip', 'Simply sexy: this little slip in smooth satin.', 2979, 7, 1, 0, 3, 1, 'Black');

INSERT INTO products (name, description, cost, type_id, in_stock, discount, size_id, brand_id, color)
VALUES ('High-low Ruffle Skirt', 'Live the dream in a cascade of ruffles finished with a shimmering band of sequins.', 12290, 7, 1, 0, 3, 1, 'Aqua white');

INSERT INTO products (name, description, cost, type_id, in_stock, discount, size_id, brand_id, color)
VALUES ('Gallant Tux', 'Impress your companion', 29000, 1, 1, 0, 4, 7, 'Dark black');

INSERT INTO products (name, description, cost, type_id, in_stock, discount, size_id, brand_id, color)
VALUES ('Moda Rapido', 'White Printed Polo T-Shirt', 3800, 5, 1, 0, 4, 12, 'Gray-white');

INSERT INTO products (name, description, cost, type_id, in_stock, discount, size_id, brand_id, color)
VALUES ('Emerald embrace', 'Warm Sweater', 12080, 3, 1, 0, 5, 4, 'Emerald');

INSERT INTO images_storage (product_id, path) VALUES (1, '/d9.41479802/main.jpg');

INSERT INTO images_storage (product_id, path) VALUES (2, '/c8.67599460/main.jpg');

INSERT INTO images_storage (product_id, path) VALUES (3, '/99.67431272/main.jpg');

INSERT INTO images_storage (product_id, path) VALUES (4, '/66.04778962/main.jpg');

INSERT INTO images_storage (product_id, path) VALUES (5, '/d7.83906298/main.jpg');

