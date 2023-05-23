# Define some constant values for the different versions of DigitalOcean databases
locals {
  mysql = {
    engine = "mysql"
    version = "8"
  }
  postgres = {
    engine = "pg"
    version = "13" # Available options: 10 | 11 | 12 | 13
  }
}

# We need to create a database cluster in DigitalOcean,
# based on Mysql 8, which is the version DigitalOcean provides.
# You can switch this out for Postgres by changing the `locals.` pointer to point at postgres.
resource "digitalocean_database_cluster" "laravel-in-kubernetes" {
  name = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  engine = local.mysql.engine # Replace with `locals.postgres.engine` if using postgres
  version = local.mysql.version # Replace with `locals.postgres.version` if using postgres
  size = "db-s-1vcpu-1gb"
  region = data.doppler_secrets.commons.map.DIGITALOCEAN_CLUSTER_REGION
  node_count = 1
}

# We want to create a separate database for our application inside the database cluster.
# This way we can share the cluster resources, but have multiple separate databases.
resource "digitalocean_database_db" "laravel-in-kubernetes" {
  cluster_id = digitalocean_database_cluster.laravel-in-kubernetes.id
  name = "${data.doppler_secrets.app.map.TRUSTUP_APP_KEY}-db"
}

# We want to create a separate user for our application,
# So we can limit access if necessary
# We also use Native Password auth, as it works better with current Laravel versions
resource "digitalocean_database_user" "laravel-in-kubernetes" {
  cluster_id = digitalocean_database_cluster.laravel-in-kubernetes.id
  name = "trustup-io-user"
}

# We want to allow access to the database from our Kubernetes cluster
# We can also add custom IP addresses
# If you would like to connect from your local machine,
# simply add your public IP
resource "digitalocean_database_firewall" "laravel-in-kubernetes" {
  cluster_id = digitalocean_database_cluster.laravel-in-kubernetes.id

  rule {
    type  = "k8s"
    value = digitalocean_kubernetes_cluster.laravel-in-kubernetes.id
  }
}