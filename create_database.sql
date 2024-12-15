CREATE DATABASE cosmetics_shop;
CREATE USER 'root@localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON cosmetics_shop.* TO 'root@localhost';
FLUSH PRIVILEGES;