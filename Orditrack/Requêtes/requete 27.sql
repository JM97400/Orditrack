LOAD DATA LOCAL INFILE 'D:\laragon\www\Dev\Orditrack\Liste-pcs.csv'
INTO TABLE pcs
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(numero_serie, status);

