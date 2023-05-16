resource "digitalocean_spaces_bucket" "main" {
  name   = var.trustup_io_app_key
  region = var.do_region

  cors_rule {
    allowed_methods = ["GET"]
    allowed_origins = ["*"]
  }
}

output "main-spaces-bucket-name" {
  value = digitalocean_spaces_bucket.main.name
}

output "main-spaces-bucket-endpoint" {
  value = digitalocean_spaces_bucket.main.endpoint
}

output "main-spaces-bucket-region" {
  value = digitalocean_spaces_bucket.main.region
}