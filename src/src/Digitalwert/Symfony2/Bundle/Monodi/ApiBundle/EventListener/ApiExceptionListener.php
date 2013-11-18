<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
/**
 * Description of ApiExceptionListener
 *
 * http://stackoverflow.com/questions/15384165/set-fosrestbundle-exception-format
 * http://symfony.com/doc/current/cookbook/service_container/event_listener.html
 *  
 * @author digitalwert
 */
class ApiExceptionListener 
{
    /**
     * 
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // do whatever tests you need - in this example I filter by path prefix
        $path = $event->getRequest()->getRequestUri();

        if (strpos($path, '/api/v1') === 0) {
            return;
        }

        $exception = $event->getException();
        $response = new JsonResponse($exception, 500);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }

        // Send the modified response object to the event
        $event->setResponse($response);
    }
}