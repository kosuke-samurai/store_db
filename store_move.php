<?php 
$pdo=new PDO('mysql:host=localhost;dbname=gs_graduation_program;charset=utf8','root','');
$sql = "SELECT * FROM store_db WHERE id = :id";
$statement=$pdo->prepare($sql);
$statement->bindValue(':id', (int)$_GET['id'],PDO::PARAM_INT);
$statement->execute();
if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];}
$detail=$statement->fetch(PDO::FETCH_ASSOC);
$statement=null;
$pdo=null;
require_once 'store_detail.php';
?>