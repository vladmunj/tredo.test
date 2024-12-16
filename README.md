# Setup

- Clone project to some directory
- Copy .env file to root of project directory
- Copy firebase-creds.json to /storage/app/private/firebase-creds.json
- Run composer update
- Run docker compose up -d (on first run cache error may occur on app container, just run docker compose down && docker compose up -d again)
- Run docker exec -it app bash
- Run php artisan make:filament-user
- Go to http://localhost:8080/admin/firebase-notifications & login
- Click on send notification button, fill form & submit
- Endpoint for register new device: [POST] http://localhost:8080/api/device/register
- Body:
```bash
    {
        "user_id": 1,
        "token": "u13uec1f120u9"
    }
```
- Headers:
```bash
    Accept: application/json
```