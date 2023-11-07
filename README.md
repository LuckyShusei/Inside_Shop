
# 最初に laravel を install （最新版）
composer create-project laravel/laravel sources --prefer-dist

composer install

# Vue と AdminLTE のインストール
https://medium.com/@crydetaan/laravel-6-vuejs-adminlte-3-1e264db76809

npm run dev
npm run watch

# Vue 側に router の制御を渡す
https://cpoint-lab.co.jp/article/202002/13924/

# Vue router について
https://reffect.co.jp/laravel/laravel-vue-router-single-page-application

# Controller 

php artisan make:model Xxx(単数形) --migration
php artisan make:controller XXXs(複数形)Controller --resource
php artisan make:seeder XXXs(複数形)TableSeeder


作り変え
php artisan migrate:refresh --seed


#IDE 補間

php artisan clear-compiled
php artisan ide-helper:generate
php artisan ide-helper:meta
php artisan ide-helper:model