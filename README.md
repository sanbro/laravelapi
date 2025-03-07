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
- **Update Project**: `PUT /api/projects/{id}`
- **Delete Project**: `DELETE /api/projects/{id}`

### Timesheets

- **List Timesheets**: `GET /api/timesheets`
- **Create Timesheet**: `POST /api/timesheets`
- **Get Timesheet**: `GET /api/timesheets/{id}`
- **Update Timesheet**: `PUT /api/timesheets/{id}`
- **Delete Timesheet**: `DELETE /api/timesheets/{id}`

### Attributes

- **List Attributes**: `GET /api/attributes`
- **Create Attribute**: `POST /api/attributes`
- **Get Attribute**: `GET /api/attributes/{id}`
- **Update Attribute**: `PUT /api/attributes/{id}`
- **Delete Attribute**: `DELETE /api/attributes/{id}`

### Attribute Values

- **List Attribute Values**: `GET /api/attribute-values`
- **Create Attribute Value**: `POST /api/attribute-values`
- **Get Attribute Value**: `GET /api/attribute-values/{id}`
- **Update Attribute Value**: `PUT /api/attribute-values/{id}`
- **Delete Attribute Value**: `DELETE /api/attribute-values/{id}`

## Example Requests/Responses

### Register

**Request:**

```json
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "password": "password"
}
```
**Response:**
```json
{
    "status": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "first_name": "John",
            "last_name": "Doe",
            "email": "john.doe@example.com",
            "updated_at": "2025-03-06T20:02:42.000000Z",
            "created_at": "2025-03-06T20:02:42.000000Z",
            "hashed_id": "MTI="
        }
    }
}
```
