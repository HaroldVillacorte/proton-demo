<?php

require 'vendor/autoload.php';
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Adapter\DoctrineAdapter;
return ConsoleRunner::createHelperSet(DoctrineAdapter::getEntityManager());
