<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
<h1> Page blog </h1>
<?php foreach ($allPost as $value)
{
    echo '<strong>'.$value['title'].'</strong> - '.$value['content'].' - '. $value['date_creation'] .'<br>';
}
?>
</body>
</html>
