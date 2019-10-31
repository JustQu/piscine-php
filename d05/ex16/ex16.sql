SELECT COUNT(DISTINCT id_last_film) AS movies
FROM `member`
WHERE date_last_film >= '2006-04-30' AND date_last_film <= '2007-07-30'
	OR (DAYOFMONTH(date_last_film) = 24 AND MONTH(date_last_film) = 12);
