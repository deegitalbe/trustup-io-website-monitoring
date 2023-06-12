locals {
  default_env = {
    BROADCAST_DRIVER = "log"
    CACHE_DRIVER = "file"
    DB_CONNECTION = "mysql"
    FILESYSTEM_DISK = "do_public"
    LOG_CHANNEL = "flare"
    LOG_DEPRECATIONS_CHANNEL = "null"
    LOG_LEVEL = "debug"
    MAIL_ENCRYPTION = "null"
    MAIL_FROM_ADDRESS = "hello@example.com"
    MAIL_HOST = "mailhog"
    MAIL_MAILER = "smtp"
    MAIL_PASSWORD = ""
    MAIL_PORT = "1025"
    MAIL_USERNAME = ""
    MEILISEARCH_HOST = "http://meilisearch:7700"
    PUSHER_APP_CLUSTER = "mt1"
    PUSHER_APP_ID = ""
    PUSHER_APP_KEY = ""
    PUSHER_APP_SECRET = ""
    PUSHER_HOST = ""
    PUSHER_PORT = "443"
    PUSHER_SCHEME = "https"
    QUEUE_CONNECTION = "redis"
    REDIS_HOST = "redis"
    REDIS_PASSWORD = ""
    REDIS_PORT = "6379"
    SCOUT_DRIVER = "meilisearch"
    SESSION_DRIVER = "redis"
    SESSION_LIFETIME = "120"
  }
}