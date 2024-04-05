<?php

namespace App\Action\Staff;
use App\Domain\Service\Staff\StaffReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class ViewStaff
{
    private $staffReaderService;

    public function __construct(StaffReader $staffReaderService)
    {
        $this->staffReaderService = $staffReaderService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');

        $data = $this->staffReaderService->getStaffById($id);

        $result = [
            'success' => $data->success,
            'message' => $data->message,
            'data' => $data->records
        ];

        $response->getBody()->write((string) json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}