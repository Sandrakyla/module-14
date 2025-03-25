<?php
require_once 'functions.php';
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SPA-салон "Райское наслаждение"</title>
    <style>
        .discount { color: red; font-weight: bold; }
        .birthday { background: gold; padding: 5px; }
    </style>
</head>
<body>
    <h1>Добро пожаловать в SPA-салон!</h1>
    
    <?php if ($user): ?>
        <p>Здравствуйте, <?= $user['name'] ?>! 
        <a href="logout.php">Выйти</a></p>
        
        <!-- Таймер скидки -->
        <?php 
        $timeLeft = 24 * 3600 - (time() - $user['login_time']);
        if ($timeLeft > 0): 
            $hours = floor($timeLeft / 3600);
            $minutes = floor(($timeLeft % 3600) / 60);
            $seconds = $timeLeft % 60;
        ?>
            <p>Ваша персональная скидка 10% истекает через: 
            <?= $hours ?>:<?= $minutes ?>:<?= $seconds ?></p>
        <?php endif; ?>
        
        <!-- Проверка дня рождения -->
        <?php 
        $daysToBirthday = checkBirthday($user['birthday']);
        if ($daysToBirthday === 0): ?>
            <div class="birthday">
                С ДНЁМ РОЖДЕНИЯ! Вам положена скидка 5% на все услуги!
            </div>
        <?php else: ?>
            <p>До вашего дня рождения осталось <?= $daysToBirthday ?> дней</p>
        <?php endif; ?>
        
    <?php else: ?>
        <p><a href="login.php">Войдите</a> для доступа к личному кабинету</p>
    <?php endif; ?>
    
    <h2>Наши услуги</h2>
    <ul>
        <li>Массаж спины - 2000 руб. <?php if ($user): ?><span class="discount">10% OFF</span><?php endif; ?></li>
        <li>SPA-программа - 5000 руб. <?php if ($user && $daysToBirthday === 0): ?><span class="discount">+5% OFF</span><?php endif; ?></li>
        <li>Уход за лицом - 3000 руб.</li>
    </ul>
    
    <h2>Акции</h2>
    <p>В этом месяце скидка 15% на все массажи по понедельникам!</p>
    <img src="spa.jpg" alt="Наш салон" width="500">
</body>
</html>