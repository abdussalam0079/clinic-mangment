# Clinic Management System

A simple PHP-based clinic management system for patient registration, appointment scheduling, and basic reporting.

## Project Structure

- `index.php` - Dashboard or home page.
- `register.php` - Patient registration form.
- `process_register.php` - Handles registration form submission.
- `appointment.php` - Appointment scheduling page.
- `schedule.php` - Daily/weekly schedule view.
- `report.php` - Reporting page for appointments/patients.
- `step1.php`, `step2.php`, `step3.php` - Multi-step workflow support pages.
- `includes/header.php`, `includes/footer.php` - Common layout components.
- `assets/style.css` - Styling.
- `assets/script.js` - Client-side behavior.

## Requirements

- PHP 7.4+ 
- Web server (Apache, Nginx, IIS)
- MySQL/MariaDB (if used by the app for persistence)

## Installation

1. Clone repository:
   ```bash
   git clone https://github.com/abdussalam0079/clinic-mangment.git
   cd clinic-mangment
   ```
2. Configure your webserver document root to this project folder.
3. Create database and import SQL schema (if provided).
4. Adjust database connection settings in the project (common location: `config.php` or included files).
5. Open `http://localhost/clinic-system/index.php` in your browser.

## Usage

- Register patients via `register.php`.
- Schedule/check appointments via `appointment.php` and `schedule.php`.
- View analytics in `report.php`.

## Notes

- This is a starting template and may require customizing database and validation logic.
- Add error handling and security improvements before production deployment.
