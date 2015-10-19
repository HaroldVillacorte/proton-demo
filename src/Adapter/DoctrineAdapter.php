<?php

namespace App\Adapter;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class DoctrineAdapter
 * @package App\Adapter
 */
class DoctrineAdapter
{
    /**
     * @var bool
     */
    public static $isDevMode = true;

    /**
     * @var array
     */
    public static $dbParams = [
        'driver'   => 'pdo_mysql',
        'user'     => 'root',
        'password' => 'root',
        'dbname'   => 'app',
    ];

    /**
     * Get the Doctrine Entity Manger.
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public static function getEntityManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(["src/Entity"], self::$isDevMode);
        return EntityManager::create(self::$dbParams, $config);
    }
}