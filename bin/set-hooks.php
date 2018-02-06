<?php
$dir = $_SERVER['argv'][1] ?? dirname(dirname(dirname(dirname(__DIR__))));
$dir = realpath($dir);
$command = new \Producer\Githooks\SetHooks();
$code = $command($dir);
exit($code);
