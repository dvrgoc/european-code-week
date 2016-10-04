DROP DATABASE europeancodeweek;

CREATE DATABASE IF NOT EXISTS europeancodeweek;

GRANT ALL PRIVILEGES ON europeancodeweek.* TO root@localhost IDENTIFIED BY 'mysql';

FLUSH PRIVILEGES;

USE europeancodeweek;