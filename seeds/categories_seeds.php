<?php
require(__DIR__ . "/../models/Category.php");
require(__DIR__ . "/../connection/connection.php");

$categories = [
    ["Tech", "Latest news in technology, gadgets and innovation."],
    ["Health", "Tips and guides for healthy living."],
    ["Travel", "Explore the world with top travel destinations."],
    ["Food", "Delicious recipes and restaurant reviews."],
    ["Education", "Resources for learning and development."]
];

foreach ($categories as [$name, $desc]) {
    Category::createcategory($mysqli, $name, $desc);
}