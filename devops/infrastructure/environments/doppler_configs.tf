resource "doppler_config" "dev_related" {
  depends_on = [ doppler_environment.dev, doppler_secret.dev_environment_secrets ]
  for_each = toset(local.dev_related_environments)
  name = replace(each.value, "-", "_")
  project = doppler_project.app.name
  environment = doppler_environment.dev.slug
}