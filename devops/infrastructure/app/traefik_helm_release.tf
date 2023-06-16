resource "helm_release" "traefik" {
  depends_on = [
    kubernetes_secret.ci_commons_token,
    kubectl_manifest.doppler,
    kubectl_manifest.doppler_traefik_secret
  ]
  namespace = kubernetes_namespace.traefik.metadata[0].name
  create_namespace = true
  name = "traefik"
  repository = "https://traefik.github.io/charts"
  chart = "traefik"
  wait = true
  timeout = 800
  values = [file("charts/traefik/values.yml")]
}