INSERT INTO loqum.anketa
( id ,email ,password ,name ,gender ,birthday ,age ,zodiac ,heigth ,weight ,about ,marital_status ,sexual_orientation ,description ,location ,icq ,phone ,mainphoto ,first_visit ,last_visit ,isdeleted ,isinactive)
SELECT 
 id ,email ,password ,name ,gender ,birthday ,age ,zodiac ,heigth ,weight ,about ,marital_status ,sexual_orientation ,description ,location ,icq ,phone ,mainphoto ,first_visit ,last_visit ,isdeleted ,isinactive
FROM atolin_omen.anketa_old
WHERE gender = 1;

INSERT INTO loqum.photo
SELECT * FROM atolin_omen.photo
WHERE id_user IN (SELECT id FROM loqum.anketa);

UPDATE loqum.anketa SET priority = UNIX_TIMESTAMP() WHERE sexual_orientation = 2;
UPDATE loqum.anketa SET priority = UNIX_TIMESTAMP()-3600*5 WHERE sexual_orientation = 3;
UPDATE loqum.anketa set about = '' WHERE sexual_orientation <>2;

UPDATE anketa SET location = 'Санкт-Петербург' WHERE location LIKE '%Санкт-Петербург%';
UPDATE anketa SET location = 'Москва' WHERE location LIKE '%Москва%';

UPDATE anketa SET location = 'Великий Новгород' WHERE location LIKE '%Саратов%' LIMIT 30;
UPDATE anketa SET location = 'Камень-на-Оби' WHERE location LIKE '%Саратов%' LIMIT 17;
UPDATE anketa SET location = 'Воркута' WHERE location LIKE '%Саратов%' LIMIT 21;
UPDATE anketa SET location = 'Гусь-Хрустальный' WHERE location LIKE '%Саратов%' LIMIT 27;
UPDATE anketa SET location = 'Дубна' WHERE location LIKE '%Саратов%' LIMIT 15;
UPDATE anketa SET location = 'Жигулевск' WHERE location LIKE '%Саратов%' LIMIT 15;
UPDATE anketa SET location = 'Белореченск' WHERE location LIKE '%Саратов%' LIMIT 15;
UPDATE anketa SET location = 'Горячий Ключ' WHERE location LIKE '%Саратов%' LIMIT 16;
UPDATE anketa SET location = 'Усть-Илимск' WHERE location LIKE '%Саратов%' LIMIT 10;

UPDATE anketa SET trial_end = UNIX_TIMESTAMP()+3600*24*365*10;


UPDATE anketa SET description = CONCAT(description,'\nпостоянные отношения') where description = ''  ORDER BY RAND() LIMIT 2500;
UPDATE anketa SET description = CONCAT(description,'\nпровести вечер') where description = '' ORDER BY RAND() LIMIT 5000;
UPDATE anketa SET description = CONCAT(description,'\nищу спонсора') where description = '' ORDER BY RAND() LIMIT 5000;
UPDATE anketa SET description = CONCAT(description,'\nстану спонсором') where description = '' ORDER BY RAND() LIMIT 2000;
UPDATE anketa SET description = CONCAT(description,'\nсовместное путешествие') where description = '' ORDER BY RAND() LIMIT 7000;
UPDATE anketa SET description = CONCAT(description,'\nсовместная аренда жилья') where description = '' ORDER BY RAND() LIMIT 10000;

-- ReID
UPDATE `anketa` set id = id-433591;
UPDATE `photo` set id_user = id_user-433591;
UPDATE anketa set id = id -3995424 WHERE id >=4499003;
UPDATE photo set id_user = id_user -3995424 WHERE id_user >=4499003;

alter table anketa AUTO_INCREMENT = SELECT MAX(id) from anketa; -- не работает и через @max=, искать в 2 запроса

DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Москва%' LIMIT 12000;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Петербург%' LIMIT 2000;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Москва%' LIMIT 1200;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Москва%' LIMIT 1200;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Петербург%' LIMIT 1000;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Красноярск%' LIMIT 300;
DELETE FROM anketa WHERE sexual_orientation = 1 AND id < 503777 AND location LIKE '%Краснодар%' LIMIT 300;


DELETE FROM photo WHERE id_user NOT IN (SELECT id FROM anketa);


UPDATE anketa SET description = CONCAT(description,'\nпостоянные отношения') where id < 503777 AND description not like '%янные%' AND LENgth(description)<30  ORDER BY RAND() LIMIT 500

UPDATE anketa SET description = CONCAT(description,'\nдружба, общение') where id < 503777 AND description not like '%ddfd%' AND LENgth(description)<60  ORDER BY RAND() LIMIT 500;
UPDATE anketa SET description = CONCAT(description,'\nрегулярный секс') where id < 503777 AND description not like '%ddfd%' AND LENgth(description)<60  ORDER BY RAND() LIMIT 500;
UPDATE anketa SET description = CONCAT(description,'\nсекс без обязательств') where id < 503777 AND description not like '%ddfd%' AND LENgth(description)<60  ORDER BY RAND() LIMIT 500;
UPDATE anketa SET description = CONCAT(description,'\nгрупповой секс') where id < 503777 AND description not like '%ddfd%' AND LENgth(description)<60  ORDER BY RAND() LIMIT 500;

UPDATE anketa SET find_from = GREATEST(18,RAND()*8+age-5), find_to = 35 + RAND()*31 where id < 503777;
UPDATE anketa SET find_to = find_from + RAND()*5 WHERE id < 503777 AND find_from > find_to;

UPDATE anketa SET sex_role = (int) 1+RAND()*5 WHERE id < 503777;