locals {
  DOPPLER_APP_CONFIG_NAME=replace(var.TRUSTUP_APP_KEY_SUFFIX, "-", "_")
}

resource "doppler_secret" "digitalocean_database_name" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DB_DATABASE"
  value = digitalocean_database_db.laravel-in-kubernetes.name
}

resource "doppler_secret" "digitalocean_database_host" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DB_HOST"
  value = digitalocean_database_cluster.laravel-in-kubernetes.host
}

resource "doppler_secret" "digitalocean_database_user_password" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DB_PASSWORD"
  value = digitalocean_database_user.laravel-in-kubernetes.password
}

resource "doppler_secret" "digitalocean_database_port" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DB_PORT"
  value = digitalocean_database_cluster.laravel-in-kubernetes.port
}

resource "doppler_secret" "digitalocean_database_user" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DB_USERNAME"
  value = digitalocean_database_user.laravel-in-kubernetes.name
}

resource "doppler_secret" "app_env" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "APP_ENV"
  value = var.APP_ENVIRONMENT
}

resource "doppler_secret" "app_debug" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "APP_DEBUG"
  value = var.APP_ENVIRONMENT != "production"
}

resource "doppler_secret" "app_key" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "APP_KEY"
  value = lookup(data.doppler_secrets.app.map, "APP_KEY", "base64:${base64sha256(var.TRUSTUP_APP_KEY_SUFFIXED)}")
}

resource "doppler_secret" "app_url" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "APP_URL"
  value = "https://${cloudflare_record.app.hostname}"
}

resource "doppler_secret" "bucket_name" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DO_BUCKET"
  value = digitalocean_spaces_bucket.main.name
}

resource "doppler_secret" "bucket_region" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DO_DEFAULT_REGION"
  value = digitalocean_spaces_bucket.main.region
}

resource "doppler_secret" "bucket_endpoint" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DO_ENDPOINT"
  value = digitalocean_spaces_bucket.main.endpoint
}

resource "doppler_secret" "bucket_secret_access_key" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DO_SECRET_ACCESS_KEY"
  value = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_SPACES_SECRET_ACCESS_KEY
}

resource "doppler_secret" "bucket_access_key_id" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "DO_ACCESS_KEY_ID"
  value = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_SPACES_ACCESS_KEY_ID
}

resource "doppler_secret" "app_name" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "APP_NAME"
  value = lookup(data.doppler_secrets.app.map, "APP_NAME", var.TRUSTUP_APP_KEY_SUFFIXED)
}

resource "doppler_secret" "same_as_suffixed_app_key" {
  for_each = toset(local.doppler.secrets.same_as_suffixed_app_key)
  config = local.DOPPLER_APP_CONFIG_NAME
  name = each.value
  value = var.TRUSTUP_APP_KEY_SUFFIXED
  project = var.TRUSTUP_APP_KEY
}

resource "doppler_secret" "flare_key" {
  project = var.TRUSTUP_APP_KEY
  config = local.DOPPLER_APP_CONFIG_NAME
  name = "FLARE_KEY"
  value = lookup(data.doppler_secrets.app.map, "FLARE_KEY", "")
}