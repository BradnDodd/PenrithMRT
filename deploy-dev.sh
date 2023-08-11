#!/bin/bash
# Setup the correct environment
set -a;
export CONTAINER_HOST_IP=$(ip route get 1.2.3.4 | head -1 | awk '{print $7}');
export USERNAME=$(whoami);
export USERID=$(id -u);
export GROUPID=$(id -g);

# Run compose with arguments passed to this script
docker-compose $@
