CREATE TABLE cafe details (
cafe id INT AUTO INCREMENT PRIMARY KEY,
cafe_name VARCHAR(100) NOT NULL,
manager_name VARCHAR(100) NOT NULL,
computer_type VARCHAR(80) NOT NULL,
location VARCHAR(150) NOT NULL,
date added TIMESTAMP DEFAULT CURRENT TIMESTAMP
);
CREATE TABLE customers (
customer id INT AUTO INCREMENT PRIMARY KEY,
customer_name VARCHAR(100) NOT NULL,
contact_number VARCHAR(50) NOT NULL,
UNIQUE KEY unique_customer (customer_name, contact_number);
CREATE TABLE reservations (
reservation id INT AUTO INCREMENT PRIMARY KEY,
customer id INT NOT NULL,
reservation_date DATE NOT NULL,
play_type ENUM("Normal". 'VIP', 'WIP') NOT NULL DEFAULT 'Normal",
hours_to_play INT NOT NULL DEFAULT 1,
notes TEXT,
status VARCHAR(30) DEFAULT 'Pending",
date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);
