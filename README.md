## CMS Creator

A basic content management system (CMS) where the
entities and attributes related to these entities are fully dynamic, the system
should have two types of actors (Admin: creates the entities and custom
attributes - Operator: Use the entities created by the admin to enter the real-life
values)

## Used packages


- **[jwt-auth](https://jwt-auth.readthedocs.io/en/develop/)**
- **[Laravel-permission](https://spatie.be/docs/laravel-permission/v5/introduction)**

### Installation and Setup

1. git clone https://github.com/SaraShoukry/CMS-Creator.git

2. composer install

3. php artisan migrate

4. php artisan db:seed --class=RolesAndPermissionsSeeder



## Built With

- **[Laravel](https://laravel.com/)**



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
