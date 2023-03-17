//start serwera bez logów
symfony server:start -d
symfony run -d yarn encore dev-server

//utworzenie tabel bazy danych
php bin/console make:migration
php bin/console doctrine:migrations:migrate

//utworzenie controllera
php bin/console make:controller
php bin/console make:registration-form