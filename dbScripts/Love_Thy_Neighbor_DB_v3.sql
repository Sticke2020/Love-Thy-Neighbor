-- Drop and recreate the database
DROP DATABASE IF EXISTS love_thy_neighbor;
CREATE DATABASE love_thy_neighbor;
USE love_thy_neighbor;

-- Drop tables is they exist
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS request;
DROP TABLE IF EXISTS user_type;
DROP TABLE IF EXISTS request_status_type;
DROP TABLE IF EXISTS business;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS log;
DROP TABLE IF EXISTS action_type;
DROP TABLE IF EXISTS report_type;
DROP TABLE IF EXISTS business_user;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS request_image;
DROP TABLE IF EXISTS feedback;


-- Create user table
CREATE TABLE `user` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `user_type_id` integer NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone` varchar(20),
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image_id` bigint,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME
);

-- Create request table
CREATE TABLE `request` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `user_id` integer NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `request_status_type_id` integer,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME
);

-- Create user_type table
CREATE TABLE `user_type` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `description` varchar(50)
);

-- Create request_status_type table
CREATE TABLE `request_status_type` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `description` varchar(255)
);

-- Create business table
CREATE TABLE `business` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME
);

-- Create message table
CREATE TABLE `message` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `sender_id` integer NOT NULL,
  `receiver_id` integer NOT NULL,
  `body` text,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` boolean
);

-- Create report table
CREATE TABLE `report` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `report_type_id` int NOT NULL,
  `user_id` integer NOT NULL,
  `body` text NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create log table
CREATE TABLE `log` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `user_id` integer,
  `action_type_id` integer,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create action_type table
CREATE TABLE `action_type` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `description` varchar(255)
);

-- Create report_type table
CREATE TABLE `report_type` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `description` varchar(255)
);

-- Create business_user table
CREATE TABLE `business_user` (
  `user_id` int,
  `business_id` int,
   `is_admin` boolean
);

-- Create image table
CREATE TABLE `image` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `user_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` text NOT NULL,
  `file_size_bytes` bigint,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create request_image table
CREATE TABLE `request_image` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `request_id` int NOT NULL,
  `image_id` bigint NOT NULL
);

-- Create feedback table
CREATE TABLE `feedback` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `author_id` int NOT NULL,
  `target_user_id` int NOT NULL,
  `comment` text NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- Add foreign keys
ALTER TABLE `user` ADD FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);

ALTER TABLE `business_user` ADD FOREIGN KEY (`business_id`) REFERENCES `business` (`id`);

ALTER TABLE `business_user` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `message` ADD FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

ALTER TABLE `message` ADD FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`);

ALTER TABLE `request` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `request` ADD FOREIGN KEY (`request_status_type_id`) REFERENCES `request_status_type` (`id`);

ALTER TABLE `report` ADD FOREIGN KEY (`report_type_id`) REFERENCES `report_type` (`id`);

ALTER TABLE `report` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `log` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `log` ADD FOREIGN KEY (`action_type_id`) REFERENCES `action_type` (`id`);

ALTER TABLE `image` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `user` ADD FOREIGN KEY (`profile_image_id`) REFERENCES `image` (`id`);

ALTER TABLE `request_image` ADD FOREIGN KEY (`request_id`) REFERENCES `request` (`id`);

ALTER TABLE `request_image` ADD FOREIGN KEY (`image_id`) REFERENCES `image` (`id`);

ALTER TABLE `feedback` ADD FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

ALTER TABLE `feedback` ADD FOREIGN KEY (`target_user_id`) REFERENCES `user` (`id`);


-- Insert user type
INSERT INTO user_type (id, description) VALUES
(1, 'Admin'),
(2, 'Moderator'),
(3, 'End User');

-- Insert request_status_type
INSERT INTO request_status_type (id, description) VALUES
(1, 'Unfulfilled'),
(2, 'Fulfilled');

-- Insert action_type
INSERT INTO action_type (id, description) VALUES
(1, 'Account Created'),
(2, 'Account Deleted'),
(3, 'Business Registered'),
(4, 'Business Deleted'),
(5, 'Login'),
(6, 'Failed Login Attempt'),
(7, 'Logout'),
(8, 'Create Request'),
(9, 'Delete Request'),
(10, 'File Report'),
(11, 'Sent Message'),
(12, 'Received Message'),
(13, 'User Type Changed'),
(14, 'Password Changed'),
(15, 'Username Changed'),
(16, 'Email Changed'),
(17, 'Phone Changed'),
(18, 'Address Changed'),
(19, 'Image Uploaded'),
(20, 'Image Removed');

-- Insert report_type
INSERT INTO report_type (id, description) VALUES
(1, 'Harassment Or Bullying'),
(2, 'Threats Or Abusive Language'),
(3, 'Impersonation'), 
(4, 'Fake Profile'),
(5, 'Spamming'), 
(6, 'Scamming'),
(7, 'Illegal Content'),
(8, 'Suspicious Behavior'),
(9, 'Technical Issue'),
(10, 'Technical Error'),
(11, 'Need Assistance');

-- Insert user
INSERT INTO user (user_type_id, first_name, last_name, city, state, zip, email_address, phone, username, password, date_created) VALUES
(1, 'Matt', 'Feagin', 'New Richmond', 'WI', 54017, 'matt@matt.com', '715-777-7777', 'Admin', 'test', NOW()),
(2, 'Alex', 'Prime', 'New Richmond', 'WI', 54017, 'prime@prime.com', '715-123-4567', 'Moderator', 'test', NOW()),
(3, 'Susan', 'Smith', 'Somerset', 'WI', 54025, 'smith@smith.com', '715-111-1111', 'Susan', 'test', NOW()),
(3, 'Ron', 'Nor', 'New Richmond', 'WI', 54017, 'ron@ron.com', '715-222-2222', 'Ronald', 'test', NOW()),
(3, 'Debbie', 'James', 'New Richmond', 'WI', 54017, 'deb@deb.com', '715-333-3333', 'Debbs', 'test', NOW()),
(3, 'Tiffany', 'Wood', 'New Richmond', 'WI', 54017, 'tiff@tiff.com', '715-444-4444', 'Tiff', 'test', NOW()),
(3, 'Samuel', 'Rose', 'Somerset', 'WI', 54025, 'sam@sam.com', '715-555-5555', 'Sammy', 'test', NOW()),
(3, 'Melissa', 'Heart', 'New Richmond', 'WI', 54017, 'mel@mel.com', '715-678-6677', 'Melissa', 'test', NOW());

-- Insert business
INSERT INTO business (name, phone, address, city, state, zip, description, verification_code, date_created) VALUES 
('Rons Automotive', '715-123-4321', '511 Main St', 'NewRichmond', 'WI', '54017', 'Rons Automotive is the one stop shop for all your automotive needs', '123123123', NOW()),
('NR Plumbing', '715-443-4342', '642 Main St', 'NewRichmond', 'WI', '54017', 'NR Plumbing, we get it done', 'testing123', NOW()),
('Glass Palace', '715-543-4114', '31 2nd St', 'NewRichmond', 'WI', '54017', 'Glass Palace, Theres no better place to get your windows today', 'xyzxyzxyz12', NOW());

-- Insert business_user
INSERT INTO business_user (user_id, business_id, is_admin) VALUES
(4, 1, TRUE),
(7, 2, TRUE),
(6, 3, TRUE);

-- Insert request
INSERT INTO request (user_id, title, body, request_status_type_id, date_created) VALUES
(3, 'Need screen door replaced', 'Hello, I have a broken screen door I need help replacing. I have a new replacement that just needs to be installed', 1, NOW()),
(5, 'Need a tire changed', 'I have a flat tire and need it to be replaced', 2, NOW()),
(8, 'Water pipe burst under my sink', 'The water pipe under my sink froze and burst, its leaking water pretty bad, I turned the valve to shut the water off but now the sink doesnt work, please help me fix it', 2, NOW());

-- Insert feedback
INSERT INTO feedback (author_id, target_user_id, comment, date_created) VALUES
(5, 4, 'Thank you so much Ron for replacing my car tire, You did a wonderful job and I will recomend Rons Automotive to everyone I know', NOW()),
(7, 8, 'Thanks for repairing the burst sink pipe Sammy!! My bathroom is dry and I can use the sink again.', NOW()),
(4, 5, 'Debbie you are a wonderful person and it was a pleasure to help you out, you made my job easy and I would be happy to help you again', NOW());

-- Insert message
INSERT INTO message (sender_id, receiver_id, body, date_created, is_read) VALUES
(4, 5, 'Hello Debbie, I am Ron the owner of Rons Automotive and I would love to replace your car tire for you', NOW(), TRUE),
(5, 4, 'Hello Ron, Thank you for the offer I would appreciate that so much are you available on Tuesday?', NOW(), TRUE),
(4, 5, 'Glad I can help, Yes I am available Tuesday, call the shop to schedule me for an onsite visit free of charge 715-123-4321', NOW(), TRUE),
(7, 8, 'Hello Melissa, I am Samuel the owner of NR Plumbing, I would like to fix your burst water pipe, if you would like to accept my offer call 715-443-4342 and we can schedule a time that works for you', NOW(), TRUE);

 -- Insert report
 INSERT INTO report (report_type_id, user_id, body, date_created) VALUES
 (11, 3, 'Hello I just wanted to report that I was having an issue changing my password, could someone please help me with this?', NOW()),
(9, 3, 'Hello I am having trouble uploading a picture, can someone help instruct me how?', NOW()),
(9, 3, 'How do I know if someone sends me a message?', NOW());  

-- Insert logs
INSERT INTO log (user_id, action_type_id, date_created) VALUES
(1, 1, NOW()), 
(2, 1, NOW()),
(3, 1, NOW()),
(4, 1, NOW()),
(5, 1, NOW()),
(6, 1, NOW()),
(7, 1, NOW()),
(8, 1, NOW());

-- Insert images
INSERT INTO image (user_id, file_name, file_url, file_size_bytes, date_created) VALUES
(3, 'c7dd3aba9592a006d1ae9b8cde83bbf4.png', 'http://localhost:8082/uploads/c7dd3aba9592a006d1ae9b8cde83bbf4.png', 16885, NOW()),
(3, '0f06038d381b71f0a2920f2be7700e99.png', 'http://localhost:8082/uploads/0f06038d381b71f0a2920f2be7700e99.png', 16885, NOW()),
(4, 'c2b12f9f83fbb9a4026a7114184b5650.png', 'http://localhost:8082/uploads/c2b12f9f83fbb9a4026a7114184b5650.png', 16885, NOW()),
(5, '2b005b6ee482a9186dc6cb5c79f76efb.png', 'http://localhost:8082/uploads/2b005b6ee482a9186dc6cb5c79f76efb.png', 16885, NOW()),
(6, '4504345c5757ca58bb692f15b702a50b.png', 'http://localhost:8082/uploads/4504345c5757ca58bb692f15b702a50b.png', 16885, NOW()),
(5, '14ffb8e23e36c464a2c2dd54913fd2bf.png', 'http://localhost:8082/uploads/14ffb8e23e36c464a2c2dd54913fd2bf.png', 17885, NOW()),
(8, '02e96f996b9c2545d47ef9af82936e15.png', 'http://localhost:8082/uploads/02e96f996b9c2545d47ef9af82936e15.png', 17885, NOW());

-- Insert request images
INSERT INTO request_image (request_id, image_id) VALUES
(1, 2),
(2, 6),
(3, 7);

-- uncomment the below if you want to use it
-- Recreate user and assign privileges
CREATE USER  IF NOT EXISTS 'mgs_user'@'%' IDENTIFIED BY 'pa55word';


GRANT SELECT, INSERT, DELETE, UPDATE ON love_thy_neighbor.* TO 'mgs_user'@'%';

FLUSH PRIVILEGES;

