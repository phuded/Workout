<?php
$hostname='173.201.136.224';//'mentalworkout.db.7613256.hostedresource.com';
$username='mentalworkout';
$password='Thorndon32!';
$dbname='mentalworkout';

$link =  mysql_connect($hostname,$username, $password);

if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname);
?>