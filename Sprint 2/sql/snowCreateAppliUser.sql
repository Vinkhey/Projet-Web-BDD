CREATE USER 'appliConnector'@'localhost' IDENTIFIED BY '12345';
GRANT SELECT, INSERT, UPDATE ON snows.* TO 'appliConnector'@'localhost';
