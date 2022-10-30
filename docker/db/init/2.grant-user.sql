CREATE USER 'sample_user'@'%' IDENTIFIED BY 'sample_pass';
GRANT ALL PRIVILEGES ON sample_db.* TO 'udemy_user'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
