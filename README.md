# Email Tracking System

This is a simple email tracking system to track email opens, clicks, and bounces.

## Features
- Track email opens using a tracking pixel.
- Track email link clicks.
- Log bounce events.
- View tracked events in a dashboard.

## Requirements
- PHP 7.0 or higher
- MySQL
- Composer

## Setup

1. Clone the repository:
    ```sh
    git clone https://github.com/your-repo/email-tracking.git
    cd email-tracking
    ```

2. Install dependencies:
    ```sh
    composer install
    ```

3. Configure the environment variables:
    - Create a `.env` file and update the values:
      ```
      DB_HOST=localhost
      DB_USER=your_db_username
      DB_PASS=your_db_password
      DB_NAME=email_tracking

      ADMIN_USERNAME=admin
      ADMIN_PASSWORD=your_hashed_password
      ```
    - Use `password_hash()` in PHP to generate a hashed password for `ADMIN_PASSWORD`.

4. Initialize the database:
    - Run `init_db.php` to create the necessary table:
      ```sh
      php init_db.php
      ```

5. Add tracking pixel and links to your emails:
    - For tracking opens:
      ```html
      <img src="https://yourdomain.com/track.php?email=user@example.com&event=open" alt="" style="display:none;">
      ```
    - For tracking clicks:
      ```html
      <a href="https://yourdomain.com/track.php?email=user@example.com&event=click&url=https://destination.com">Click Here</a>
      ```

6. Set up bounce handling (optional):
    - Configure your email service provider to send bounce events to `https://yourdomain.com/bounce.php`.

7. Access the dashboard:
    - Open `https://yourdomain.com/login.php` in your browser and log in to view the tracking data.

8. Generate a Hashed Password for admin

    - Use the following PHP code snippet to generate a hashed password for the admin:

      '''php
      ' <?php
        echo password_hash('your_admin_password', PASSWORD_DEFAULT);
      ?> '

   
## License
This project is licensed under the MIT License.
