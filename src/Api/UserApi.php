<?php

namespace App\Api;

use App\Adapter\DoctrineAdapter;
use App\Entity\StandardResponse;
use Doctrine\ORM\Query;
use App\Entity\User;

/**
 * Class UserApi
 * @package App\Api
 */
class UserApi
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->em = DoctrineAdapter::getEntityManager();
    }

    /**
     * @return array
     */
    public function getAllEmployees()
    {
        $response = new StandardResponse();
        $queryString = "SELECT user.id, user.name, user.role, user.email, user.phone, user.created_at, user.updated_at " .
            "FROM \App\Entity\User user WHERE user.role = 'employee'";
        $query = $this->em->createQuery($queryString);
        $results = $query->getArrayResult();
        if ($results) {
            $response->setSuccess(true);
            $response->setMessage('Here are the employees.');
            $response->setData($results);
        }
        return $response->getObjectVars();
    }
}