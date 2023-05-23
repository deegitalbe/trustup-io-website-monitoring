resource "doppler_secret" "digitalocean_kubernetes_cluster_id" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production-ci" #TODO
  name = "DIGITALOCEAN_KUBERNETES_CLUSTER_ID"
  value = digitalocean_kubernetes_cluster.laravel-in-kubernetes.id
}

resource "doppler_secret" "digitalocean_database_name" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production" #TODO
  name = "DB_DATABASE"
  value = digitalocean_database_db.laravel-in-kubernetes.name
}

resource "doppler_secret" "digitalocean_database_host" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production" #TODO
  name = "DB_HOST"
  value = digitalocean_database_cluster.laravel-in-kubernetes.host
}

resource "doppler_secret" "digitalocean_database_user_password" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production" #TODO
  name = "DB_PASSWORD"
  value = digitalocean_database_user.laravel-in-kubernetes.password
}

resource "doppler_secret" "digitalocean_database_port" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production" #TODO
  name = "DB_PORT"
  value = digitalocean_database_cluster.laravel-in-kubernetes.port
}

resource "doppler_secret" "digitalocean_database_user" {
  project = data.doppler_secrets.app.map.TRUSTUP_APP_KEY
  config = "production" #TODO
  name = "DB_USERNAME"
  value = digitalocean_database_user.laravel-in-kubernetes.name
}