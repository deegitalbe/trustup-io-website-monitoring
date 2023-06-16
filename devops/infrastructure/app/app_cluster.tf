data "digitalocean_kubernetes_versions" "kubernetes-version" {
  version_prefix = "1.24."
}

data "digitalocean_sizes" "small" {
  filter {
    key    = "slug"
    values = ["s-1vcpu-2gb"]
  }
}

resource "digitalocean_kubernetes_cluster" "laravel-in-kubernetes" {
  # name = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  name = var.TRUSTUP_APP_KEY_SUFFIXED
  region = data.doppler_secrets.ci_commons.map.DIGITALOCEAN_CLUSTER_REGION

  # Latest patched version of DigitalOcean Kubernetes.
  # We do not want to update minor or major versions automatically.
  version = data.digitalocean_kubernetes_versions.kubernetes-version.latest_version

  # We want any Kubernetes Patches to be added to our cluster automatically.
  # With the version also set to the latest version, this will be covered from two perspectives
  auto_upgrade = true
  maintenance_policy {
    # Run patch upgrades at 4AM on a Sunday morning.
    start_time = "04:00"
    day = "sunday"
  }

  node_pool {
    # name = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
    name = var.TRUSTUP_APP_KEY_SUFFIXED
    size = "${element(data.digitalocean_sizes.small.sizes, 0).slug}"
    node_count = 1
    # We can autoscale our cluster according to use, and if it gets high,
    # We can auto scale to maximum 5 nodes.
    auto_scale = false
    # min_nodes = 1
    # max_nodes = 5

    # These labels will be available in the node objects inside of Kubernetes,
    # which we can use as taints and tolerations for workloads.
    labels = {
      pool = "default"
      size = "small"
    }
  }
}

resource "kubernetes_namespace" "app" {
  metadata {
    name = "app"
  }
}

resource "kubernetes_namespace" "traefik" {
  metadata {
    name = "traefik"
  }
}