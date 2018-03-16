<!DOCTYPE html>
<html lang="en" style="margin-top: 0px !important;">
    <head>
        <title><?php wp_title('|', true, 'right'); bloginfo('name');?></title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" type="image/x-icon">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
       <link rel="alternate" type="application/rss+xml" title="Royal Legal Solutions feed" href="/feed.xml">
        <?php wp_head(); ?>
    </head>


    <body <?php body_class(); ?>>

        <nav class="<?= (is_front_page()) ? 'transparent' : '';?>">
            <i class="fa fa-bars"></i>

            <div class="left horizontal menu">
                <?php get_template_part('snippets/header/nav-left'); ?>
            </div>
            <div class="right horiziontal menu">
                <?php get_template_part('snippets/header/nav-right'); ?>
            </div>
        </nav>

        <?php
        if (is_front_page() || is_page('landing')) {
            get_template_part('snippets/header/video');
        }
        else {
            echo '<header class="spacer"></header>';
        } ?>
