# producer/githooks

Naive Git hooks, installable by Composer.

Add the following to your composer file:

```
{
    "require-dev": {
        "producer/githooks": "~0.x"
    }
}
```

After `composer install` or `composer update`, issue the following to set
the Git hooks:

```
php ./vendor/producer/githooks/bin/set-hooks.php
```

That creates, or appends to, `.git/hooks/pre-commit` file to run a PHP linter on
added, copied, and modified PHP files before `git commit`.
