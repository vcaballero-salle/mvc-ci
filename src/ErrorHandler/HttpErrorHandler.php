<?php
declare(strict_types=1);

namespace SallePW\ErrorHandler;

use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Handlers\ErrorHandler;
use Psr\Http\Message\ResponseInterface;

final class HttpErrorHandler extends ErrorHandler
{
    protected function respond(): ResponseInterface
    {

        if ($this->exception instanceof HttpNotFoundException) {
            $response = $this->responseFactory->createResponse(404);
            $response->getBody()->write('Sorry, the url that you are looking for does not exist.');
            return $response;
        }

        if ($this->exception instanceof HttpMethodNotAllowedException) {
            $response = $this->responseFactory->createResponse(405);
            $response->getBody()->write('Sorry, the url that you are looking for does not exist.');
            return $response;
        }

        return parent::respond();
    }
}