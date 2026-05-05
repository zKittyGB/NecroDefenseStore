-- NecroDefenseStore - base SQL import file
-- Target: MySQL 8+
SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `necroDefenseStore`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `necroDefenseStore`;

-- Schema tables must be generated from Doctrine entities in an environment
-- where Composer dependencies are available, with:
--   php bin/console doctrine:schema:create --dump-sql
-- Then replace this placeholder section by the generated CREATE TABLE statements.
