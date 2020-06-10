# cua_webinterface
The Web Interface for CUA

# Install

Configure the `DATABASE_URL` variable in your `.env.local` at the project root.

Run theirs commands:

```shell script
$ composer install
$ bin/console doctrine:migration:migrate
```

# Run localy with Symfony client

Run:

```shell script
$ symfony serve
```

