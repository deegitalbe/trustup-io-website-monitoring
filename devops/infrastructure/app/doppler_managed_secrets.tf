resource "kubernetes_manifest" "doppler_app_commons_secret" {
  manifest = yamldecode(file("manifests/doppler/secrets/app/commons-secret.yml"))
}

resource "kubernetes_manifest" "doppler_app_secret" {
  manifest = yamldecode(file("manifests/doppler/secrets/app/secret.yml"))
}

resource "kubernetes_manifest" "doppler_traefik_secret" {
  manifest = yamldecode(file("manifests/doppler/secrets/traefik/secret.yml"))
}

