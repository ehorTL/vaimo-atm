<?php

/**
 Main script for application work demonstration.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Bank\IbanGeneratorImpl;

$g = new IbanGeneratorImpl();
print $g->generate();





