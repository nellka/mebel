TRUNCATE message_count;
REPLACE INTO message_count
SELECT LEAST( id_from, id_to ) , GREATEST( id_from, id_to ), count( id ) ,
id_from > id_to as start_2,
max(datestamp)as datestamp
FROM message
GROUP BY CONCAT(LEAST(id_from,id_to),GREATEST(id_from,id_to))
ORDER BY datestamp DESC;

LOCK TABLES message WRITE;
DROP TRIGGER IF EXISTS insert_message;
CREATE TRIGGER `insert_message` AFTER INSERT ON message
FOR EACH ROW
	INSERT INTO message_count SET
	id1 = LEAST(NEW.id_from, NEW.id_to),
	id2 = GREATEST(NEW.id_from, NEW.id_to),
	start_2 = NEW.id_from > NEW.id_to,
	last_time = NEW.datestamp
	ON DUPLICATE KEY UPDATE
	`cnt` = `cnt`+1,
	last_time = NEW.datestamp;
UNLOCK tables;




SELECT m.id1, m.id2, last_time FROM
(
SELECT m.id1, m.id2, last_time
FROM `message_count` m
WHERE (m.id1 = 4932794)

UNION

SELECT m.id2, m.id1, last_time
FROM `message_count` m
WHERE (m.id2 = 4932794)
) m
WHERE m.id2 IN

(SELECT id_to FROM message2folder m2f
WHERE m2f.id_from = 4932794 AND m2f.id_folder = 0)

ORDER BY last_time desc;