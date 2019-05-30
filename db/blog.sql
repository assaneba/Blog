-- *********************************
-- ***** DATABASE blog *****
-- *********************************
 
-- Drops the old database before creates a new one
DROP DATABASE IF EXISTS blog;
 
-- Creates the database blog
CREATE DATABASE blog CHARACTER SET 'utf8';
 
-- Uses the database blog
USE blog;

-- -----------------------------------------------------
-- Table `blog`.`user`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`user` (
  `iduser` TINYINT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(88) NOT NULL,
  `first_name` VARCHAR(75) NOT NULL,
  `last_name` VARCHAR(25) NOT NULL,
  `email` VARCHAR(85) NOT NULL,
  `user_role` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- Insertion des données de la table `user`
--
INSERT INTO `user` (`iduser`,`login`, `password`, `first_name`, `last_name`, `email`, `user_role`) 
VALUES
(1, 'JohnSnow', 'passer', 'John', 'Snow', 'johnsnow@sonmail.com', 'ROLE_ADMIN'),
(2, 'AryaStaks', 'passer', 'Arya', 'Starks', 'arya@sonmail.com', 'ROLE_USER'),
(3, 'Varice', 'passer', 'Lord', 'Varice', 'varice@sonmail.com', 'ROLE_USER');


-- -----------------------------------------------------
-- Table `blog`.`post`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`post` (
  `idpost` SMALLINT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL UNIQUE,
  `lead` VARCHAR(250) NULL,
  `content` VARCHAR(2500) NOT NULL,
  `date_creation` DATETIME NOT NULL,
  `post_public` BOOLEAN NOT NULL,
  `date_planned` DATETIME NULL,
  `user_iduser` TINYINT NOT NULL,
  PRIMARY KEY (`idpost`, `user_iduser`),
  INDEX `fk_post_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `blog`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Insertion des données de la table `post`
--
INSERT INTO `post` (`idpost`,`title`, `lead`, `content`, `date_creation`, `post_public`, `date_planned`, `user_iduser`) 
VALUES
(1, 'Mon premier post', 'Lead of the post', 'content of the post', '2019-05-05 12:08:00', 1, NULL, 1),
(2, 'Mon deuxieme post', 'Lead of the post', 'content of the post', '2019-05-05 12:08:00', 1, NULL, 1),
(3, 'Mon troisieme post', 'Lead of the post', 'content of the post', '2019-05-05 12:08:00', 1, NULL, 1);

-- -----------------------------------------------------
-- Table `blog`.`category`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`category` (
  `idcategory` TINYINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcategory`))
ENGINE = InnoDB;


-- Insertion des données de la table `category`
--
INSERT INTO `category` (`idcategory`,`name`) 
VALUES
(1, 'Uncategorized'),
(2, 'Tech'),
(3, 'Society');


-- -----------------------------------------------------
-- Table `blog`.`modif_post`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`modif_post` (
  `date_modif` DATETIME NOT NULL,
  `post_idpost` SMALLINT NOT NULL,
  PRIMARY KEY (`date_modif`, `post_idpost`),
  INDEX `fk_modif_post_post1_idx` (`post_idpost` ASC),
  CONSTRAINT `fk_modif_post_post1`
    FOREIGN KEY (`post_idpost`)
    REFERENCES `blog`.`post` (`idpost`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- Insertion des données de la table `modif_post`
--
INSERT INTO `modif_post` (`date_modif`,`post_idpost`) 
VALUES
('2019-05-05 12:08:00', 1),
('2019-05-05 12:08:00', 2);


-- -----------------------------------------------------
-- Table `blog`.`comment`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`comment` (
  `idcomment` MEDIUMINT NOT NULL AUTO_INCREMENT,
  `date_comment` DATETIME NOT NULL,
  `date_last_modif` DATETIME NOT NULL,
  `content` VARCHAR(450) NOT NULL,
  `published` BOOLEAN NOT NULL,
  `post_idpost` SMALLINT NOT NULL,
  `user_iduser` TINYINT NOT NULL,
  PRIMARY KEY (`idcomment`, `post_idpost`, `user_iduser`),
  INDEX `fk_comment_post1_idx` (`post_idpost` ASC),
  INDEX `fk_comment_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_comment_post1`
    FOREIGN KEY (`post_idpost`)
    REFERENCES `blog`.`post` (`idpost`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `blog`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Insertion des données de la table `comment`
--
INSERT INTO `comment` (`idcomment`,`date_comment`, `date_last_modif`, `content`, `published`, `post_idpost`, `user_iduser`) 
VALUES
(1, '2019-05-05 12:08:00', '2019-05-05 12:08:00', 'Content of the comment', 1, 1, 2),
(2, '2019-05-05 12:08:00', '2019-05-05 12:08:00', 'Content of the comment', 1, 1, 3),
(3, '2019-05-05 12:08:00', '2019-05-05 12:08:00', 'Content of the comment', 0, 1, 2);

-- -----------------------------------------------------
-- Table `blog`.`category_has_post`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `blog`.`category_has_post` (
  `category_idcategory` TINYINT NOT NULL,
  `post_idpost` SMALLINT NOT NULL,
  PRIMARY KEY (`category_idcategory`, `post_idpost`),
  INDEX `fk_category_has_post_post1_idx` (`post_idpost` ASC),
  INDEX `fk_category_has_post_category_idx` (`category_idcategory` ASC),
  CONSTRAINT `fk_category_has_post_category`
    FOREIGN KEY (`category_idcategory`)
    REFERENCES `blog`.`category` (`idcategory`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_has_post_post1`
    FOREIGN KEY (`post_idpost`)
    REFERENCES `blog`.`post` (`idpost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- Insertion des données de la table `category_has_post`
--
INSERT INTO `category_has_post` (`category_idcategory`,`post_idpost`) 
VALUES
(2, 3),
(3, 2);

