resource "kubernetes_deployment" "cron" {
  metadata {
    name = local.app.cron.name
    namespace = kubernetes_namespace.app.metadata[0].name
    labels = local.app.cron.labels
    annotations = local.app.commons.annotations
  }
  spec {
    replicas = 1
    selector {
      match_labels = local.app.cron.labels
    }
    template {
      metadata {
        labels = local.app.cron.labels
      }
      spec {
        container {
          name = local.app.cron.name
          image = replace(local.app.commons.docker.image, local.app.commons.docker.placeholder, local.app.cron.name)
          env_from {
            secret_ref {
              name = kubernetes_secret.app_commons_token.metadata[0].name
            }
          }
          env_from {
            secret_ref {
              name = kubernetes_secret.app_token.metadata[0].name
            }
          }
        }
      }
    }
  }
}