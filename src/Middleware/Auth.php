<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use App\Api\AccountApi;
use App\Adapter\DoctrineAdapter;
use App\Entity\StandardResponse;

/**
 * Class Auth
 * @package App\Middleware
 */
class Auth implements HttpKernelInterface
{
    /**
     * @var HttpKernelInterface
     */
    protected $app;

    /**
     * @param HttpKernelInterface $app
     */
    public function __construct(HttpKernelInterface $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $em = DoctrineAdapter::getEntityManager();
        if (isset($_COOKIE['token'])) {
            $token = unserialize($_COOKIE['token']);
            $key = $token['key'];
            $user = $em->find('App\Entity\User', $token['id']);
            $this->app->user = $user;
            $role = $user->getRole();
        } else {
            $key = null;
            $role = null;
        }
        $route = $request->getPathInfo();
        $protectedRoutes = [
            '/shifts' => [
                'access' => ['manager']
            ],
        ];
        if (array_key_exists($route, $protectedRoutes) &&
            ( (!$key || $key !== AccountApi::$secretKey) || !in_array($role, $protectedRoutes[$route]['access']))) {
            header('Content-Type', 'application/json');
            $response = new StandardResponse();
            $response->setMessage('You are not authorized to access this route.');
            echo json_encode($response->getObjectVars());
        } else {
            return $this->app->handle($request);
        }
    }
}