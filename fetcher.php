<?php

$env = parse_ini_file('.env');

$servername = $env["SERVERADRESS"];
$username = $env["USERNAME"];
$password = $evn["PASSWORD"];
$dbname = $env["DBNAME"];

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stringPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
    $arrPosts = json_decode($stringPosts, true);
    foreach ($arrPosts as $post) {
        $stmt = $conn->prepare("INSERT INTO posts (userId, id, title, body) VALUES (:userId, :id, :title, :body)");
        $stmt->bindParam(':userId', $post['userId']);
        $stmt->bindParam(':id', $post['id']);
        $stmt->bindParam(':title', $post['title']);
        $stmt->bindParam(':body', $post['body']);
        $stmt->execute();
    }

    $stringComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
    $arrComments = json_decode($stringComments, true);
    foreach ($arrComments as $comment) {
        $stmt = $conn->prepare("INSERT INTO commentaries (postId, id, name, email, body) VALUES (:postId, :id, :name, :email, :body)");
        $stmt->bindParam(':postId', $comment['postId']);
        $stmt->bindParam(':id', $comment['id']);
        $stmt->bindParam(':name', $comment['name']);
        $stmt->bindParam(':email', $comment['email']);
        $stmt->bindParam(':body', $comment['body']);
        $stmt->execute();
    }

    $conn = null;
    $postCount = count($arrPosts);
    $commentCount = count($arrComments);
    echo "Загружено $postCount записей и $commentCount комментариев";
} catch (PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}