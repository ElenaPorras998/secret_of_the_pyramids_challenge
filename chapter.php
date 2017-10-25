<?php

function db_connect()
{
    $db = new PDO('mysql:host=localhost;dbname=pyramid;charset=utf8','root','rootroot');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;    
}

if($_GET)
{
    $id=$_GET['id'];
}
else
{
    $id=1;
}

$db = db_connect();

$stmt = $db->prepare(
    'SELECT *
    FROM chapter 
    WHERE id = ?;');
$stmt ->execute([$id]);
$content = $stmt->fetch();
//var_dump($content);

$stmt = $db->prepare(
    'SELECT *
    FROM illustration 
    WHERE chapter_id = ?;');
$stmt ->execute([$id]);
$images = $stmt->fetch();
//var_dump($images);

$stmt = $db->prepare(
    'SELECT *
    FROM choice 
    WHERE chapter_id = ?;');
$stmt ->execute([$id]);
$choices = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chapter <?php echo $content['id'];?></title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="text">
        <p><?php echo $content['text'];?></p>
    </div>

    <div id="imag">
        <img src="img/<?php echo $images['filename'];?>">
    </div>

    <div id="choice">
    <?php foreach($choices as $choice):?>
        <a href="chapter.php?id=<?php echo $choice['goto_id']; ?>"><button><?php echo $choice ['text'];?></button></a>
    <?php endforeach;?>
    </div>

</body>
</html>