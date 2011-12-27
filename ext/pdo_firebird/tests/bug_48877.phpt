--TEST--
PDO_Firebird: bug 48877 test
--SKIPIF--
<?php extension_loaded("pdo_firebird") or die("skip"); ?>
--FILE--
<?php /* $Id: rowCount.phpt 316540 2011-09-12 13:41:28Z mariuz $ */

require("testdb.inc");

$dbh = new PDO("firebird:dbname=$test_base",$user,$password) or die;
$value = '2';
@$dbh->exec('DROP TABLE testz');
$dbh->exec('CREATE TABLE testz (A integer)');
$dbh->exec("INSERT INTO testz VALUES ('1')");
$dbh->exec("INSERT INTO testz VALUES ('2')");
$dbh->exec("INSERT INTO testz VALUES ('3')");
$dbh->commit();

$query = "SELECT * FROM testz WHERE A = :paramno";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':paramno', $value, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetch();
var_dump($stmt->fetch());
var_dump($stmt->rowCount());


$stmt = $dbh->prepare('DELETE FROM testz');
$stmt->execute();

$dbh->commit();

$dbh->exec('DROP TABLE testz');

unset($stmt);
unset($dbh);

?>
--EXPECT--
bool(false)
int(1)
