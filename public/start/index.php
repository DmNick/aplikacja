<!DOCTYPE html>
<html lang="pl-PL">
<head></head>
<body>
<main>
<h3>Instrukcja do uruchomienia wersji testowej na localhost:</h3><hr>
<div>cd ~</div>
<div>mkdir aplikacja</div>
<div>git clone https://DmNick@bitbucket.org/projektdb/aplikacja.git aplikacja</div>
<div>cd aplikacja</div>
<div>composer install</div>
<div>yarn install</div>
<small>--- do prod</small>
<div>yarn run encore production</div>
<div>composer dump-env prod</div>
<small>--- end do prod</small>
<div>mysql -u root -h localhost</div>
<div>mysql> CREATE DATABASE projekt;</div>
<div>mysql> exit;</div>
<div>symfony console doctrine:schema:update --force</div>
<div>symfony server:start -d</div>
<div>symfony -d yarn run dev-server</div>
<p><hr>
<small>PHP version 8.1.2<br>
Composer version 2.5.5<br>
Symfony CLI version 5.5.2<br>
yarn version 1.22.19<br>
mysql version 8.0.32<br>
<small></p>
</main>
</body>
</html>
