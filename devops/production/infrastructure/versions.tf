terraform {
  required_providers {
    digitalocean = {
      source = "digitalocean/digitalocean"
      version = "~> 2.11"
    }
    doppler = {
      source = "DopplerHQ/doppler"
    }
  }
}