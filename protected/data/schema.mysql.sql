CREATE DATABASE template COLLATE utf8_general_ci;
use template;
CREATE USER 'template'@'localhost' IDENTIFIED BY  'template';
GRANT ALL PRIVILEGES ON  `template` . * TO  'template'@'localhost';