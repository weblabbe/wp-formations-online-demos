<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php
    wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <nav>
        <?php wp_nav_menu(array('theme_location' => 'main-nav')); ?>
    </nav>
</header>