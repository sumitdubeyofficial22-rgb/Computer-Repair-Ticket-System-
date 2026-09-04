CREATE TABLE repair_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    device_type VARCHAR(50) NOT NULL,
    device_model VARCHAR(100) NOT NULL,
    problem VARCHAR(500) NOT NULL,
    priority VARCHAR(20) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO repair_tickets
(
    customer_name,
    device_type,
    device_model,
    problem,
    priority,
    status
)
VALUES
(
    'Amit Sharma',
    'Laptop',
    'Dell Inspiron 15',
    'Laptop is not charging',
    'High',
    'Pending'
),
(
    'Neha Patil',
    'Desktop',
    'HP ProDesk',
    'System is running slowly',
    'Medium',
    'In Progress'
),
(
    'Rahul Verma',
    'Laptop',
    'Lenovo IdeaPad',
    'Keyboard keys are not working',
    'Low',
    'Completed'
),
(
    'Priya Joshi',
    'All-in-One',
    'HP Pavilion',
    'Screen display is flickering',
    'High',
    'Pending'
),
(
    'Arjun Mehta',
    'Desktop',
    'Dell OptiPlex',
    'Computer does not start',
    'High',
    'In Progress'
);