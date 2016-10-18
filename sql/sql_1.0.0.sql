CREATE DATABASE IF NOT EXISTS europeancodeweek DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci;

USE europeancodeweek;

GRANT ALL PRIVILEGES ON europeancodeweek.* TO root@localhost IDENTIFIED BY 'mysql';

FLUSH PRIVILEGES;