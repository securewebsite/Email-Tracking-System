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

## Setup

1. Clone the repository:
    ```sh
    git clone https://github.com/your-repo/email-tracking.git
    cd email-tracking
    ```

2. Configure the database connection:
    - Open `config.php` and update the database connection details:
      ```php
      $servername = "localhost";
      $username = "your_db_username";
      $password = "your_db_password";
      $dbname = "email_tracking";
      ```

3. Initialize the database:
    - Run `init_db.php` to create the necessary table:
      ```sh
      php init_db.php
      ```

4. Add tracking pixel and links to your emails:
    - For tracking opens:
      ```html
      <img src="https://yourdomain.com/track.php?email=user@example.com&event=open" alt="" style="display:none;">
      ```
    - For tracking clicks:
      ```html
      <a href="https://yourdomain.com/track.php?email=user@example.com&event=click&url=https://destination.com">Click Here</a>
      ```

5. Set up bounce handling (optional):
    - Configure your email service provider to send bounce events to `https://yourdomain.com/bounce.php`.

6. Access the dashboard:
    - Open `https://yourdomain.com/dashboard.php` in your browser to view the tracking data.

## License
This project is licensed under the MIT License.
