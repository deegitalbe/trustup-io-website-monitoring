terraform {
  required_providers {
    doppler = {
      source = "DopplerHQ/doppler"
    }
    digitalocean = {
      source = "digitalocean/digitalocean"
      version = "~> 2.11"
    }
  }
  backend "s3" {
    endpoint                    = "ams3.digitaloceanspaces.com"
    key                         = "trustup-io-testing-bucket.tfstate"
    region                      = "ams3"
    skip_credentials_validation = true
    skip_metadata_api_check     = true
    skip_region_validation      = true
  }
}

provider "doppler" {
  doppler_token = var.DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_CI_COMMONS
  alias = "ci_commons"
}

data "doppler_secrets" "ci_commons" {
  provider = doppler.ci_commons
}

provider "digitalocean" {
  token = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_ACCESS_TOKEN
  spaces_access_id  = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_SPACES_ACCESS_KEY_ID
  spaces_secret_key = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_SPACES_SECRET_ACCESS_KEY
}

variable "DOPPLER_ACCESS_TOKEN_TRUSTUP_IO_CI_COMMONS" {
  type = string
}