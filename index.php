<?php

echo(nl2br("Welcome to my preloading test\nThe secrets of the day are:\n"));

include("/tmp/secrets.php");

var_dump($secrets);

echo(nl2br("\nThis was found in the preloaded opcache file /tmp/secrets.php\nThat file no longer appears on disk. Here are the contents of /tmp:\n"));

var_dump(shell_exec("ls /tmp"));

