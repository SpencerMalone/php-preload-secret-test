# php-preload-secret-test

Handling secrets with applications is a tricky thing.

This gets worse when you aren't using a nice orchestration layer like k8s to assist with this stuff.

How can you handle secrets without having a file like `secret.ini` or `secret.env` hanging around your disk in a place where the web application can read it?

How can you utilize a secret manager without the performance hit of having to make a request to this new service for literally every request you make?

How can you have all of this around a legacy PHP application AND avoid having a risky $_ENV, since PHP debugging tools all love to dump that.




Here's the idea:
1) Have a script similar to preload.php. This is your interface with the secret manager. It pulls the secrets from the secret manager into an associative array. Once it pulls the secrets down, it uses var_export to write a php script that defines this into a more global definition (whether that be a global var or a class wrapper, up to you). Then include that script, then it deletes that temporary PHP file it had generated.
2) Set opcache's ini settings to have... `opcache.preload=` pointing at your preload.php equivalent.
3) Create a custom user for this script, set `opcache.preload_user` to use this user. Set that user as the only one with read access to the script.

As soon as your actual web app calls `include("/tmp/secret.php")`, it will actually load the opcache'd version of the script (the real one having long been deleted). The tradeoff here is that you will always be using cached results from the secret manager, but it should have near 0 performance impact and greatly improved reliability.


To see the general idea in action, run `./test.sh` while you have docker running locally.