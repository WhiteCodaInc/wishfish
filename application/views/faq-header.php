<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <link href="<?= base_url() ?>assets/img/favicon.ico" rel="Shortcut Icon" type="image/x-icon" />

        <link href="<?= base_url() ?>assets/faq/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/faq/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/faq/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <!-- JQuery -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->

        <!-- JQuery UI -->
        <!--<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>-->

        <!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>-->

        <script src="<?= base_url() ?>assets/faq/js/jquery.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/faq/js/bootstrap.min.js"></script>
    </head>
    <body class="home-1 faq-accordion">
        <!-- Navbar -->
        <header class="banner navbar navbar-static-top" role="banner">
            <div class="container">

                <div class="navbar-header">

                    <div class="navbar-brand">
                        <a title="KnowledgePress" href="index.html"><img src="<?= base_url() ?>assets/faq/img/logo.png" alt="KnowledgePress"/></a>
                    </div>

                    <button data-target=".nav-responsive" data-toggle="collapse" type="button" class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <nav class="nav-main hidden-xs" role="navigation">
                    <ul id="menu-main" class="nav navbar-nav">
                        <li class="active dropdown">
                            <a class="dropdown-toggle" data-target="#" href="index.html">Home</a>
                            <ul class="dropdown-menu">
                                <li><a href="index2.html">Home 2</a></li>
                            </ul>
                        </li>
                        <li><a href="knowledgebase.html">Knowledge Base</a></li>
                        <li><a href="articles.html">Articles</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-target="#" href="faq-accordion.html">FAQ</a>
                            <ul class="dropdown-menu">
                                <li><a href="faq-accordion.html">FAQ Accordion</a></li>
                                <li><a href="faq.html">FAQ Default</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-target="#" href="#">Features</a>
                            <ul class="dropdown-menu">
                                <li><a href="contact.html">Contact Page</a></li>
                                <li><a href="full.html">Full Width Page</a></li>
                                <li><a href="components.html">B3 Components</a></li>
                                <li><a href="columns.html">Columns</a></li>
                                <li><a href="typography.html">Typography</a></li>
                                <li><a href="videos.html">Responsive Videos</a></li>
                            </ul>
                        </li>
                    </ul>    
                </nav>

                <!-- Responsive Nav -->
                <div class="visible-xs">
                    <nav class="nav-responsive collapse" role="navigation">
                        <ul class="nav">
                            <li><a href="index.html">Home</a></li>
                            <li><a class="responsive-submenu" href="index2.html">Home 2</a></li>
                            <li><a href="knowledgebase.html">Knowledge Base</a></li>
                            <li><a href="articles.html">Articles</a></li>
                            <li><a href="faq-accordion.html">FAQ</a></li>
                            <li><a class="responsive-submenu" href="faq-accordion.html">FAQ Accordion</a></li>
                            <li><a class="responsive-submenu" href="faq.html">FAQ Default</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a class="responsive-submenu" href="contact.html">Contact Page</a></li>
                            <li><a class="responsive-submenu" href="full.html">Full Width Page</a></li>
                            <li><a class="responsive-submenu" href="components.html">B3 Components</a></li>
                            <li><a class="responsive-submenu" href="columns.html">Columns</a></li>
                            <li><a class="responsive-submenu" href="typography.html">Typography</a></li>
                            <li><a class="responsive-submenu" href="videos.html">Responsive Videos</a></li>
                        </ul>       
                    </nav>
                </div>

            </div>
        </header>