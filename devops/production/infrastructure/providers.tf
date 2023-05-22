provider "digitalocean" {
  token = data.doppler_secrets.commons.digitalocean_access_token
  spaces_access_id  = data.doppler_secrets.commons.digitalocean_spaces_access_id
  spaces_secret_key = data.doppler_secrets.commons.digitalocean_spaces_secret_key
}

provider "doppler" {
  doppler_token = var.doppler_ci_commons_token
  alias = "commons"
}

provider "doppler" {
  doppler_token = var.doppler_ci_app_token
  alias = "app"
}