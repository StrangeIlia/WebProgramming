<?php

/** @var $models app\models\Video[]*/

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <section class="form-group">
        <?php foreach ($models as $video): ?>
            <?= $video->description ?>
        <?php endforeach; ?>
    </section>
</body>
</html>