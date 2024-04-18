<?php
require_once ("www/include/class.pdogsb.inc.php");

$config = include('config.php');

$chaineConnexion = 'mysql:host=' . $config["host"] . ';dbname=' . $config["database"];
// demande que le dialogue se fasee en utilisant l'encodage utf-8
// et le mode de gestion des erreurs soit les exceptions
$params = array (   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
// crée une instance de PDO (connexion avec le serveur MySql) 
$monPdo = new PDO($chaineConnexion,  $config["user"], $config["password"], $params); 

$query = "SELECT id, mdp FROM Visiteur";
$cmd = $monPdo -> prepare($query);
$cmd->execute();
$lignes = $cmd->fetchAll();

foreach($lignes as $ligne){
 $query ='UPDATE Visiteur SET `mdp`=? WHERE id=?';
 $cmd = $monPdo->prepare($query);
 $hash = password_hash($ligne['mdp'], PASSWORD_BCRYPT);
 $cmd->bindValue(1, $hash);
 $cmd->bindValue(2, $ligne['id']);
 $cmd->execute();
}


//$monPdo->commit();


