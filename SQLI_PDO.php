<?php

ob_start();
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db = "new";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo $e->getMessage();
}

//SELECT

$query = "SELECT * FROM comments ORDER BY comment_id DESC";
$result = $conn->prepare($query);    
$result->execute();    
while($row = $result->fetch()){
$comment_id   = $row['comment_id'];
$comment_user = $row['comment_user']; }
//
$query = "SELECT * FROM posts WHERE comment_id= 34 ORDER BY post_id DESC";
        $result = $conn->prepare($query);  
        $result->execute();
        foreach($result->fetchall() as $v => $x){
        $post_id            = $x['post_id'];
        $post_title         = $x['post_title'];}
//
$app=$_GET['app'];
$query = "SELECT * FROM posts WHERE comment_id= ? ORDER BY post_id DESC";
$result = $conn->prepare($query);  
$result->execute([$app]);

//UPDATE

$app="ff";
$query="UPDATE comments SET comment_status = 'approve' WHERE comment_id='$app'";
$result = $conn->prepare($query);    
$result->execute();    

$query="UPDATE comments SET comment_status = ? WHERE comment_id = ?";
$result = $conn->prepare($query);    
$result->execute(['approve',$app]);    

//DELETE

$del=$_GET['del'];
$query="DELETE FROM comments WHERE comment_id= ?";
$result = $conn->prepare($query);    
$result->execute([$del]);    

//INSERT

$query = "INSERT INTO posts(post_title, post_date, post_image, post_content, post_tags, post_status)
VALUES(?, now(), ?, ?, ?,?)";      
$result = $conn->prepare($query);    
$result->execute([$post_title, $post_image, $post_content, $post_tags, $post_status]);    
$id = $conn->lastInsertId();

//MYSQLI_NUM_ROWS

$query="SELECT COUNT(*) FROM users WHERE user_name='$user'";
$result=$conn->prepare($query);
$result->execute();
$count =$result->fetchColumn();