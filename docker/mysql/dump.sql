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

-- Insert base products
INSERT INTO `products` (`code`, `name`, `price`)
VALUES ('R01', 'Red Widget', 32.95),
       ('G01', 'Green Widget', 24.95),
       ('B01', 'Blue Widget', 7.95);


-- Shopping cart
CREATE TABLE `carts`
(
    `id`         int       NOT NULL AUTO_INCREMENT,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- Cart items
CREATE TABLE `cart_items`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `cart_id`      int         NOT NULL,
    `product_code` varchar(10) NOT NULL,
    `quantity`     int         NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_cart_product` (`cart_id`, `product_code`),
    CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_code`) REFERENCES `products` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
