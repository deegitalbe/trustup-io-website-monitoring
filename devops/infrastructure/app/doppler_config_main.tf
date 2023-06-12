data "kubectl_file_documents" "doppler_manifests" {
  content = file("manifests/doppler/main.yml")
}

resource "kubectl_manifest" "doppler" {
  for_each   = data.kubectl_file_documents.doppler_manifests.manifests
  yaml_body  = each.value
}

resource "kubernetes_secret" "ci_commons_token" {
  type = "Opaque"
  metadata {
    name = "trustup-io-ci-commons-token-secret"
    namespace = local.doppler.namespace
  }
  data = {
    serviceToken = "${data.doppler_secrets.ci_commons.map.DOPPLER_SERVICE_TOKEN_TRUSTUP_IO_CI_COMMONS}"
  }
}

resource "kubernetes_secret" "app_commons_token" {
  type = "Opaque"
  metadata {
    name = "trustup-io-app-commons-secret"
    namespace = local.doppler.namespace
  }
  data = {
    serviceToken = "${data.doppler_secrets.ci_commons.map.DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_APP_COMMONS}"
  }
}

resource "kubernetes_secret" "app_token" {
  type = "Opaque"
  metadata {
    name = "trustup-io-app-secret"
    namespace = local.doppler.namespace
  }
  data = {
    serviceToken = "${local.DOPPLER_APP_SERVICE_TOKEN}"
  }
}