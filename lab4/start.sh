#!/bin/sh
IMAGE_NAME="php_image"
CONTAINER_NAME="php_container"
PORT="8080"

SCRIPT_DIR="$(pwd)/$(dirname "$0")"
docker build -t $IMAGE_NAME $SCRIPT_DIR
docker run -d -p $PORT:80 --name $CONTAINER_NAME -v $SCRIPT_DIR/src:/var/www/html $IMAGE_NAME
