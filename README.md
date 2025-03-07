# Project Management API

## Setup Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your environment variables
4. Run `php artisan migrate --seed`
5. Run `php artisan passport:install`
6. Run `php artisan serve`

## API Documentation

### Authentication

- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Logout**: `POST /api/logout`

### Projects

- **List Projects**: `GET /api/projects`
- **Create Project**: `POST /api/projects`
- **Get Project**: `GET /api/projects/{id}`
- **Update Project**: `POST /api/projects/{id}`
- **Delete Project**: `DELETE /api/projects/{id}`

### Timesheets

- **List Timesheets**: `GET /api/timesheets`
- **Create Timesheet**: `POST /api/timesheets`
- **Get Timesheet**: `GET /api/timesheets/{id}`
- **Update Timesheet**: `POST /api/timesheets/{id}`
- **Delete Timesheet**: `DELETE /api/timesheets/{id}`

### Attributes

- **List Attributes**: `GET /api/attributes`
- **Create Attribute**: `POST /api/attributes`
- **Get Attribute**: `GET /api/attributes/{id}`
- **Update Attribute**: `POST /api/attributes/{id}`
- **Delete Attribute**: `DELETE /api/attributes/{id}`

## API Documentation of POSTMAN
## 🔥 Postman Collection
Use the Postman collection to test the API:

- **Download Collection:** [postman_collection.json](API Astudio.postman_collection.json)
- **Online Collection:** [View in Postman](https://documenter.getpostman.com/view/14976123/2sAYdmnTzY)

### 📌 How to Import Postman Collection
1. Open **Postman**.
2. Click **Import** > Select **API Astudio.postman_collection.json**.
3. Start testing the API.
