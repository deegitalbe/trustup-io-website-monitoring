data "doppler_secrets" "commons" {
  provider = doppler.commons
}

data "doppler_secrets" "app" {
  provider = doppler.app
}

data "digitalocean_kubernetes_versions" "kubernetes-version" {
  version_prefix = "1.24."
}

data "digitalocean_sizes" "small" {
  filter {
    key    = "slug"
    values = ["s-1vcpu-2gb"]
  }
}