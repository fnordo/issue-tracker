<?php

namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * RequestListener.
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class RequestListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage,AuthorizationCheckerInterface $authorizationChecker,
                                RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
    }

    /**
     * If an authenticated user visits the login page, redirect to issues index.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest() || !$this->tokenStorage->getToken()) {
            return;
        }

        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }

        if ($event->getRequest()->get('_route') === 'fos_user_security_login') {
            $url = $this->router->generate('issue_index');
            $event->setResponse(new RedirectResponse($url));
        }
    }
} 