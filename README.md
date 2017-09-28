Chunks domain counter
===================
## Installation ##

```
run migration
php /migration/db.sql

run seeder

php ./src/seeder/Seeder.php
```

## Usage ##
```php

$counter = new \App\DomainCounter(new \App\DB('localhost', 'test_task', 'root', 'root'));

//separate chunks, 100000 rows per pass
var_dump($counter->calculate(100000));

```