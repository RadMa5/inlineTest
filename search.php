<?php 

$env = parse_ini_file('.env');

$servername = $env["SERVERADRESS"];
$username = $env["USERNAME"];
$password = $evn["PASSWORD"];
$dbname = $env["DBNAME"];

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $r = $_GET['search'];

    if (isset($r)) {
        $stmt = $conn->prepare("SELECT postId, name, body FROM commentaries WHERE name LIKE :search OR body LIKE :search");
        $stmt->bindValue(':search', '%' . $r . '%');
        $stmt->execute();
        $commentaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $commentaries = [];
    }

    $posts = [];

    foreach ($commentaries as $comment){
        $postQuery = $conn->prepare("SELECT title FROM posts WHERE id = :postId");
        $postQuery->bindValue(':postId', $comment['postId']);
        $postQuery->execute();
        $postTitle = $postQuery->fetch(PDO::FETCH_ASSOC);
        $posts[] = [
            'commentName' => $comment['name'],
            'commentBody' => $comment['body'],
            'postTitle' => $postTitle['title']
        ];
    }

    $commString = json_encode($posts, JSON_UNESCAPED_UNICODE);
    echo $commString;
} catch (PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
