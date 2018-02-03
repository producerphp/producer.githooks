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

Creates, or appends to, `.git/hooks/pre-commit` to run a PHP linter on
added, copied, and modified PHP files before committing.
