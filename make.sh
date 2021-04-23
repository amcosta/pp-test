composer install
php bin/console lexik:jwt:generate-keypair
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction