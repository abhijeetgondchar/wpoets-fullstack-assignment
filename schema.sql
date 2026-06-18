-- WPoets Full Stack Developer Test
-- Database schema and seed data setup

CREATE DATABASE IF NOT EXISTS `wpoets_test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `wpoets_test`;

-- Drop tables if they exist to allow clean re-runs
DROP TABLE IF EXISTS `slides`;
DROP TABLE IF EXISTS `tabs`;

-- Create tabs table
CREATE TABLE `tabs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `icon` VARCHAR(255) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create slides table
CREATE TABLE `slides` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tab_id` INT NOT NULL,
  `badge` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `button_text` VARCHAR(100) DEFAULT 'Learn More',
  `button_link` VARCHAR(255) DEFAULT '#',
  `image` VARCHAR(255) NOT NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_slides_tabs` FOREIGN KEY (`tab_id`) REFERENCES `tabs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed tabs
INSERT INTO `tabs` (`id`, `title`, `icon`, `sort_order`) VALUES
(1, 'Learning', 'images/DL-learning.svg', 1),
(2, 'Technology', 'images/DL-technology.svg', 2),
(3, 'Communication', 'images/DL-communication.svg', 3);

-- Seed slides
INSERT INTO `slides` (`tab_id`, `badge`, `title`, `button_text`, `button_link`, `image`, `sort_order`) VALUES
(1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Usability enhancement and Training for Transaction Portal for Customers', 'Learn More', '#', 'images/DL-Learning-1.jpg', 1),
(1, 'E-LEARNING METHODOLOGIES', 'Interactive training simulations to align distributed departments', 'Learn More', '#', 'images/DL-Learning-1.jpg', 2),
(2, 'ENTERPRISE TECHNOLOGY PACKAGES', 'Cloud infrastructure scaling and workflow digitization for legacy systems', 'Learn More', '#', 'images/DL-Technology.jpg', 1),
(3, 'STRATEGIC COMMUNICATION', 'Brand positioning, workshops, and internal communication strategies', 'Learn More', '#', 'images/DL-Communication.jpg', 1);
