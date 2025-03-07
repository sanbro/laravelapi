# Project Management API

### 1 Clone the Repository
Run the following command to clone the project:
```bash
git clone git@github.com:sanbro/laravelapi.git
cd your-repository
```

### 2 Install Dependencies
Run the following command to install PHP dependencies:
```bash
composer install
```

### 3 Configure Environment Variables
- Copy the `.env.example` file to `.env`:
  ```bash
  cp .env.example .env
  ```
- Open `.env` and set up your **database credentials**:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  ```

### 4 Generate Application Key
```bash
php artisan key:generate
```

### 5 Run Database Migrations & Seeders
Run migrations to create tables and seeders to insert sample data:
```bash
php artisan migrate --seed
```

### 6 Install Laravel Passport
Since authentication uses Laravel Passport, run:
```bash
php artisan passport:install
```
You may do this by executing the passport:client Artisan command with the --personal option
```bash
php artisan passport:client --personal
```
- Copy the **client secret** and update it in `.env` under:
  ```env
  PASSPORT_PERSONAL_ACCESS_CLIENT_ID=your_client_id
  PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=your_client_secret
  ```

### 7 Start the Development Server
Run the Laravel server using:
```bash
php artisan serve
```
Your API will be available at: **`http://127.0.0.1:8000`**

### 8 (Optional) Setup Storage & Caching
Run the following to optimize the project:
```bash
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

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
##  Postman Collection
Use the Postman collection to test the API:

- **Download Collection:** [postman_collection.json](API Astudio.postman_collection.json)
- **Online Collection:** [View in Postman](https://documenter.getpostman.com/view/14976123/2sAYdmnTzY)

###  How to Import Postman Collection
1. Open **Postman**.
2. Click **Import** > Select **API Astudio.postman_collection.json**.
3. Start testing the API.

### Test Credential
- **Email:** john@example.com
- **Email:** password
