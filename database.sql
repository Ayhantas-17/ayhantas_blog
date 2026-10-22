CREATE DATABASE IF NOT EXISTS `ayhantas_blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ayhantas_blog`;

-- Blog Yazilari Tablosu
CREATE TABLE IF NOT EXISTS `posts` (
`id` INT AUTO_INCREMENT PRIMARY KEY,
`title` VARCHAR(255) NOT NULL,
`content` TEXT NOT NULL,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ornek Ilk Blog Yazisi
INSERT INTO `posts` (`title`, `content`) VALUES
(' Hos Geldiniz!', 'Merhaba!.');