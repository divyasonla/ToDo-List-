<?php 
$host = 'localhost';
$name = 'root';
$password = null;
$database = 'todo';

$conn = new mysqli($host,$name,$password,$database);
// $sql  = 'CREATE TABLE todos(
// id int primary key AUTO_INCREMENT,
// project_name varchar(100) not null,
// descriptions text,
// `start_date` date ,
// end_date date )';
// if(mysqli_query($conn,$sql)){
//     echo "tables created succefully";
// }
// else{
//     echo "not created";
// }
?>