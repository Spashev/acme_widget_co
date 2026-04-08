-- Products catalogue
CREATE TABLE `products`
(
    `id`    int            NOT NULL AUTO_INCREMENT,
    `code`  varchar(10)    NOT NULL,
    `name`  varchar(255)   NOT NULL,
    `price` decimal(10, 2) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_products_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `products` (`code`, `name`, `price`) VALUES
('R01', 'Red Widget', 32.95),
('G01', 'Green Widget', 24.95),
('B01', 'Blue Widget', 7.95);
