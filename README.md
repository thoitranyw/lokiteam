# Loki hackathon app


## 1. Deployment guide

**Config ENV**

Create file `.env`, and change env

```
APP_NAME=loki
APP_ENV=production
APP_KEY=base64:vUr73omjSPnaMlN4u6YW7G3/GlMIG61hyZYbqnu3feY=
APP_DEBUG=false
APP_URL=https://loki.fireapps.io

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=production_hostname
DB_PORT=product_db_port
DB_DATABASE=loki
DB_USERNAME=loki
DB_PASSWORD=production_db_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SHOPIFY_API_KEY=d143a8c6027023647a20d6cd4baeea05
SHOPIFY_SECRET_KEY=c1ee427dab488abb984e3c52f29e5162
```

**Dockerfile**


