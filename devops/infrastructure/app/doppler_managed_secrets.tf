resource "kubectl_manifest" "doppler_app_commons_secret" {
  yaml_body  = file("manifests/doppler/secrets/app/commons-secret.yml")
}

resource "kubectl_manifest" "doppler_app_secret" {
  yaml_body  = file("manifests/doppler/secrets/app/secret.yml")
}

resource "kubectl_manifest" "doppler_traefik_secret" {
  yaml_body  = file("manifests/doppler/secrets/traefik/secret.yml")
}

