#!/bin/bash

function retrieveExistingProject() {
  echo "$(curl \
    --header "Authorization: Bearer B86vwAlTkSzRhA.atlasv1.TL5aoRvjjIiH52MzGLy0l9yOnL8xUvoD7Q2Czn98HGsGC2mEvU9EJBPad0VBcmymDeA" \
    --header "Content-Type: application/vnd.api+json" \
    https://app.terraform.io/api/v2/organizations/deegital/projects?filter[names]=$1 \
    | jq -r '.data[0].id')"
}

function createNewProject() {
  echo "$(curl \
    --request POST \
    --header "Authorization: Bearer B86vwAlTkSzRhA.atlasv1.TL5aoRvjjIiH52MzGLy0l9yOnL8xUvoD7Q2Czn98HGsGC2mEvU9EJBPad0VBcmymDeA" \
    --header "Content-Type: application/vnd.api+json" \
    --data '{"data": {"attributes": {"name": "'$1'"}, "type": "projects"}}' \
    https://app.terraform.io/api/v2/organizations/deegital/projects \
    | jq -r '.data.id')"
}

function retrieveProject() {
  id="$(retrieveExistingProject $1)"

  if [[ ! $id == null ]]
    then echo $id
      return
  fi

  id="$(createNewProject $1)"

  if [[ $id == null ]]
    then exit 1
      return
  fi

  echo $id
}

function retrieveExistingWorkspace() {
  echo "$(curl \
    --header "Authorization: Bearer B86vwAlTkSzRhA.atlasv1.TL5aoRvjjIiH52MzGLy0l9yOnL8xUvoD7Q2Czn98HGsGC2mEvU9EJBPad0VBcmymDeA" \
    --header "Content-Type: application/vnd.api+json" \
    "https://app.terraform.io/api/v2/organizations/deegital/workspaces?filter[project][id]=$1&search[name]=$2" \
    | jq -r '.data[0].id')"
}

function createNewWorkspace() {
  echo "$(curl \
    --request POST \
    --header "Authorization: Bearer B86vwAlTkSzRhA.atlasv1.TL5aoRvjjIiH52MzGLy0l9yOnL8xUvoD7Q2Czn98HGsGC2mEvU9EJBPad0VBcmymDeA" \
    --header "Content-Type: application/vnd.api+json" \
    --data '{"data": {"attributes": {"name": "'$2'"}, "relationships": {"project": {"data": {"id": "'$1'"}}}, "type": "workspaces"}}' \
    https://app.terraform.io/api/v2/organizations/deegital/workspaces \
    | jq -r '.data.id')"
}

function retrieveWorkspace() {
  id="$(retrieveExistingWorkspace $1 $2)"

  if [[ ! $id == null ]]
    then echo $id
      return
  fi

  id="$(createNewWorkspace $1 $2)"

  if [[ $id == null ]]
    then exit 1
      return
  fi

  echo $id
}

projectId="$(retrieveProject $1)"
retrieveWorkspace $projectId $1-$2

# example execution
# ./devops/production/kubernetes/scripts/terraform/workspace.sh trustup-io-testing production