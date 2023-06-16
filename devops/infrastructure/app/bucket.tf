resource "digitalocean_spaces_bucket" "main" {
  name   = var.TRUSTUP_APP_KEY_SUFFIXED
  region = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_CLUSTER_REGION

  cors_rule {
    allowed_methods = ["GET"]
    allowed_origins = ["*"]
  }
}
