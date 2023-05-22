# resource "digitalocean_spaces_bucket" "main" {
#   name   = data.doppler_secrets.app.map.trustup_app_key
#   region = data.doppler_secrets.commons.map.digitalocean_region

#   cors_rule {
#     allowed_methods = ["GET"]
#     allowed_origins = ["*"]
#   }
# }

# output "main-spaces-bucket-name" {
#   value = digitalocean_spaces_bucket.main.name
# }

# output "main-spaces-bucket-endpoint" {
#   value = digitalocean_spaces_bucket.main.endpoint
# }

# output "main-spaces-bucket-region" {
#   value = digitalocean_spaces_bucket.main.region
# }