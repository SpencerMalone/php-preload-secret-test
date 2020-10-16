<?php

// A key/value set that represents what you would normally retrieve from a secret manager.
// In a real instance, you might access a secret manager using a password from a unique linux account
// You could specify that linux account with `opcache.preload_user`
// As long as you keep your file permissions for this file locked down, it would limit your problems to root escalations
$secrets_from_remote=["test"=>rand(0,100), "dbpass"=>"abc", "port"=>123,"gcppass"=>"xyz☃
 (in case you use strange unicode characters in a pass?)"];

$secret_text=var_export($secrets_from_remote, true);

$temp = fopen("/tmp/secrets.php", "w");
fwrite($temp, "<?php \$secrets=$secret_text;");
include("/tmp/secrets.php");
fclose($temp); 
unlink("/tmp/secrets.php");