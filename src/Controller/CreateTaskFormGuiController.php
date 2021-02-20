<?php
declare(strict_types=1);

namespace SallePW\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

final class CreateTaskFormGuiController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function getFormAction(RequestInterface $request, ResponseInterface $response)
    {
        return $this->twig->render($response, 'create_task.twig');
    }
}
