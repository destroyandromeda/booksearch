<?php if($article): ?>
    <h1><?=$article['title'];?></h1>
    <p><?=$article['text'];?></p>
<?php else: ?>
    <h2>Статья не найдена</h2>
<?php endif; ?>

