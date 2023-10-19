<?php defined('BASE_DIR') || exit;

// Frontend routes
$this->router->add('', 'index');
$this->router->add('ajax', 'ajax');

// Admin panel routes
$this->router->add('admin', 'admin/index');
$this->router->add('admin/listings', 'admin/listings');
$this->router->add('admin/products', 'admin/products');