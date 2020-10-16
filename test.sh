#!/bin/bash

docker build -f Dockerfile -t php-preload-test:latest .

docker run -ti --rm -d --name php-preload-test -p 80:80 php-preload-test:latest

sleep 3

curl localhost:80/index.php

docker kill php-preload-test > /dev/null