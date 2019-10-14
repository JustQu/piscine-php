SELECT * FROM distrib
WHERE id_distrib REGEXP "^42|62|63|64|65|66|67|68|69|71|88|89|90$"
OR NAME REGEXP "^[^yY]*[yY][^yY]*[yY][^yY]*$"
LIMIT 2, 5;