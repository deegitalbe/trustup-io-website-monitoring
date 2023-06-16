#!/bin/bash

function emptyFile() {
  true > .env.docker
}

function addProjectEnv() {
  project=$1
  doppler secrets download \
    --project $project \
    --config dev \
    --no-file \
    --format env | grep -v '^DOPPLER_' \
    >> .env.docker
}

emptyFile 
addProjectEnv "trustup-io-website-monitoring"
addProjectEnv "trustup-io-app-commons"