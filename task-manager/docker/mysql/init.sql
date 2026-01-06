-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS laravel;

-- Grant all privileges to the laravel user
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'%';
FLUSH PRIVILEGES;
