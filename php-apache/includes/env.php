<?php

$MYSQL_DATABASE_HOST = 'maxshoes.cbqf4ibv1izd.eu-central-1.rds.amazonaws.com';
$MYSQL_DATABASE_NAME = 'MaxShoes';
$MYSQL_USER = 'Dzndzo9632139';
$MYSQL_PASSWORD = 'sdklj32l23lhk';
$PHPMAILER_CLIENTID = "{23575631036-se2v9n11ggd018d638a2vr07oqmn9kj0.apps.googleusercontent.com}";
$PHPMAILER_CLIENTSECRET = "{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}";
$PHPMAILER_REDIRECT_URI = 'http://localhost:8080/vendor/phpmailer/phpmailer/get_oauth_token.php';
$PHPMAIL_SENDER = 'kneza96123@gmail.com';
$PHPMAIL_PASSWORD = 'byzkvhrfggnyulnd';
$PHP_SHA1_STRING = 'fdh345hdsf3';
define("BASEQUERY", "SELECT 
p.id AS patika_id, 
p.model AS patika_model, 
s.src AS slika_src,
s.alt AS slika_alt, 
k.naziv AS kategorija_naziv,
b.naziv AS brend_naziv,
c.vrednost AS bazna_cena,
pop.procenat AS popust,
cp.vrednost AS cena_postarine,
IFNULL((c.vrednost * pop.procenat), c.vrednost) AS snizena_cena
FROM 
patika p
INNER JOIN (
    SELECT 
        patika_id, 
        vrednost
    FROM 
        cena
    WHERE 
        datum_pocetka <= NOW() AND (datum_kraja IS NULL OR datum_kraja >= NOW())
) c ON p.id = c.patika_id
LEFT JOIN (
    SELECT 
        patika_id, 
        procenat
    FROM 
        popust
    WHERE 
        datum_pocetka <= NOW() AND (datum_kraja IS NULL OR datum_kraja >= NOW())
) pop ON p.id = pop.patika_id
LEFT JOIN (
    SELECT 
        patika_id, 
        vrednost
    FROM 
        cena_postarine
    WHERE 
        datum_pocetka <= NOW() AND (datum_kraja IS NULL OR datum_kraja >= NOW())
) cp ON p.id = cp.patika_id
INNER JOIN kategorija k ON k.id = p.kategorija_id
INNER JOIN brend b ON b.id = p.brend_id
INNER JOIN slika s ON s.id = p.slika_id 
");
?>