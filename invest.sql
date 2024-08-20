-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema invest
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `invest` DEFAULT CHARACTER SET utf8mb4 ;
USE `invest` ;

-- -----------------------------------------------------
-- Table `invest`.`modelos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `invest`.`modelos` (
  `idmodelo` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(145) NULL DEFAULT NULL,
  `percent_cdi` DECIMAL(8,2) NULL DEFAULT NULL,
  `taxa_aa` DECIMAL(8,2) NULL DEFAULT NULL,
  `prefixado` ENUM('S', 'N') NULL DEFAULT 'N',
  `ativo` ENUM('S', 'N') NULL DEFAULT 'S',
  PRIMARY KEY (`idmodelo`),
  INDEX `idx_mod_tx` (`descricao` ASC, `percent_cdi` ASC, `taxa_aa` ASC, `prefixado` ASC, `ativo` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `invest`.`selic` (
  `taxa` DECIMAL(8,2) NULL DEFAULT 10.50,
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
