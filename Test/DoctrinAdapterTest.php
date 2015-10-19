<?php

require 'bootstrap.php';

use App\Adapter\DoctrineAdapter;

/**
 * Class DoctrineAdapterTest
 */
class DoctrineAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests the DoctrineAdapter class static EntityManger getter.
     */
    public function testCanGetEntityManager() {
        $em = DoctrineAdapter::getEntityManager();
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $em);
    }
}