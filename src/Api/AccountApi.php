<?php

namespace App\Api;

use App\Entity\StandardResponse;
use App\Entity\User;
use App\Adapter\DoctrineAdapter;

/**
 * Class AccountFactory
 * @package App\Factory
 */
class AccountApi
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @var string
     */
    protected static $password = 'password';

    /**
     * @var string
     */
    public static $secretKey = 'superSecretKey';

    /**
     * @var array
     */
    public static $roles = [
        'employee' => 'employee',
        'manager' => 'manager',
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->em = DoctrineAdapter::getEntityManager();
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function login($email, $password)
    {
        $response = new StandardResponse();
        $em = DoctrineAdapter::getEntityManager();
        $user = $em->getRepository('App\Entity\User')->findOneBy(['email' => (string)$email]);
        $isValid = ($user && $password === self::$password);
        if ($isValid) {
            $response->setSuccess(true);
            $response->setMessage('You have successfully logged in!');
            $response->setData([
                'id' => $user->getId(),
                'key' => self::$secretKey,
            ]);
        }
        return $response->getObjectVars();
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function addUser(array $data)
    {
        $em = DoctrineAdapter::getEntityManager();
        $user = new User();
        $user->setName($data['name']);
        $user->setRole($data['role']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);
        $user->setCreatedAt($data['created_at']);
        $user->setUpdatedAt($data['updated_at']);
        $em->persist($user);
        try {
            $em->flush();
            return $user;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param int $id
     * @return StandardResponse
     */
    public function getUser($id)
    {
        $response = new StandardResponse();
        $response->setMessage('User not found');
        $queryString = 'SELECT user FROM \App\Entity\User user WHERE user.id = :id';
        $user = $this->em->createQuery($queryString)->setParameter('id', (int)$id)->getArrayResult();
        if (isset($user[0])) {
            $response->setSuccess(true);
            $response->setMessage('Here is the user.');
            $response->setData($user[0]);
        }
        return $response->getObjectVars();
    }

}