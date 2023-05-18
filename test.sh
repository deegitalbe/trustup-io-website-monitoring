#!/bin/bash

ip=
count=0
wait=10
maxAttempts=1

getIp() {
  kubectl get services \
   --namespace traefik \
   traefik \
   --output jsonpath='{.status.loadBalancer.ingress[0].ip}'
}

setIp() {
  ip="$(getIp)"
}

increment() {
  ((count++))
}

notYetReady() {
  echo "Waiting for load balancer external ip... [$(($count * $wait))s elapsed]"
}

setIp
until [[ (! -z $ip) || $count > $maxAttempts ]]; do
  notYetReady
  setIp
  increment
  sleep 10
done

if [[ -z $ip ]]
  then exit 1
fi

echo "Load balancer external ip is [$ip]"