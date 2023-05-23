provider "digitalocean" {
  token = data.doppler_secrets.commons.map.DIGITALOCEAN_ACCESS_TOKEN
  # spaces_access_id  = data.doppler_secrets.commons.map.digitalocean_spaces_access_id
  # spaces_secret_key = data.doppler_secrets.commons.map.digitalocean_spaces_secret_key
}

provider "doppler" {
  doppler_token = var.DOPPLER_CI_APP_TOKEN
  alias = "app"
}

provider "doppler" {
  doppler_token = var.DOPPLER_CI_COMMONS_TOKEN
  alias = "commons"
}

provider "doppler" {
  doppler_token = var.DOPPLER_CI_USER_TOKEN
}