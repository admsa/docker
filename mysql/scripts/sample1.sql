create database sample1;
create user 'sample1'@'%' identified by 'sample1';
grant all privileges on sample1.* to 'sample1'@'%' identified by 'sample1';
flush privileges;

