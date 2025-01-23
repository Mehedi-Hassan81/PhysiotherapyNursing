-- Create database (if not already created)
CREATE DATABASE IF NOT EXISTS healthcare;

-- Use the database
USE healthcare;

-- Create patient table
CREATE TABLE patient (
    patient_id INT AUTO_INCREMENT PRIMARY KEY, -- Primary key, unique, not null
    first_name VARCHAR(255) NOT NULL,          -- First name, varchar(255), not null
    last_name VARCHAR(255) NOT NULL,           -- Last name, varchar(255), not null
    DOB DATE NOT NULL,                         -- Date of birth, date, not null
    gender VARCHAR(255) NOT NULL,              -- Gender, varchar(255), not null
    contact VARCHAR(255) NOT NULL,             -- Contact, varchar(255), not null
    email VARCHAR(255) NOT NULL,               -- Email, varchar(255), not null
    NID VARCHAR(255) NOT NULL,                 -- National ID, varchar(255), not null
    password VARCHAR(255) NOT NULL,            -- Password, varchar(255), not null
    house_no VARCHAR(255),                     -- House number, varchar(255), optional
    road_no VARCHAR(255),                      -- Road number, varchar(255), optional
    city VARCHAR(255),                         -- City, varchar(255), optional
    district VARCHAR(255),                     -- District, varchar(255), optional
    postal_code INT UNIQUE,                    -- Postal code, int, unique, not null
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp for creation
);

