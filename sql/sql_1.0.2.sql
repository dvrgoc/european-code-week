INSERT INTO articles (title, short_description, price) VALUES ("T-Shirt for men", "White, short-sleeved with a large black letter T on the front", 20);
INSERT INTO articles (title, short_description, price) VALUES ("Hoodie long sleeves", "V-neck Hoodie Casual, antiperspirant", 25);
INSERT INTO articles (title, short_description, price) VALUES ("Black Leather Jacket", "Score some style with this black matte leather jacket", 60);
INSERT INTO articles (title, short_description, price, promo_price) VALUES ("Waterproof boots", "Want a pair of stylish rain boots", 100, 80);

INSERT INTO categories (title, short_description) VALUES ("Clothes", "Our clothes are Fashion-forward");
INSERT INTO categories (title, short_description, parent_cat_id) VALUES ("Tracksuits", "Get great deals on our range of Men's Tracksuits", 1);
INSERT INTO categories (title, short_description, parent_cat_id) VALUES ("Polo Shirts", "Shop the Latest Collection of Polo Shirts for Men", 1);
INSERT INTO categories (title, short_description, parent_cat_id) VALUES ("Jackets", "Good jackets for all occasions", 1);
INSERT INTO categories (title, short_description) VALUES ("Shoes", "Slip into a pair that define your personality");
INSERT INTO categories (title, short_description, parent_cat_id) VALUES ("Waterproof", "Wide selection of waterproof shoes", 5);
INSERT INTO categories (title, short_description, parent_cat_id) VALUES ("Boots", "For hiking, work and the weekend", 5);