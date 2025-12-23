CREATE TABLE `craft_area`
(
    `ID`         int(10)          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `NAME`       varchar(255) NOT NULL,
    `CODE`       varchar(255) NOT NULL,
    `ACTIVE`     char(1)      NOT NULL,
    `SORT`       int(10)          NOT NULL,
    `CREATED_AT` datetime NULL DEFAULT null,
    `UPDATED_AT` datetime NULL DEFAULT null
) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';


CREATE TABLE `craft_area_field`
(
    `ID`       int(10)          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `AREA_ID`  int(10) NOT NULL,
    `NAME`     varchar(255) NOT NULL,
    `CODE`     varchar(255) NOT NULL,
    `TYPE`     varchar(255) NOT NULL,
    `ACTIVE`   char(1)      NOT NULL,
    `MULTIPLE` char(1)      NOT NULL,
    `SORT`     int(10) NOT NULL,
    `SETTINGS` longtext NULL,
    CONSTRAINT `fk_craft_area_field_craft_area`
        FOREIGN KEY (`AREA_ID`)
            REFERENCES `craft_area` (`ID`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';

CREATE TABLE `craft_area_content`
(
    `AREA_ID`       int(10)      NOT NULL,
    `AREA_BLOCK_ID` int(10)  NOT NULL,
    `VALUE`         longtext NOT NULL,
    UNIQUE `unique_areaId_areaBlockId` (`AREA_ID`,`AREA_BLOCK_ID`),
    CONSTRAINT `fk_jaf_jac`
        FOREIGN KEY (`AREA_BLOCK_ID`)
            REFERENCES `craft_area_field` (`ID`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
) ENGINE='InnoDB' COLLATE 'utf8mb4_general_ci';