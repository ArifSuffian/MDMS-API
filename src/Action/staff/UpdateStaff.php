<?php

namespace App\Action\Staff;

use App\Domain\Service\Staff\StaffUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class UpdateStaff
{
    private $staffUpdater;

    public function __construct(StaffUpdater $staffUpdater)
    {
        $this->staffUpdater = $staffUpdater;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $status = null;

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');

        $data = (array) $request->getParsedBody();

        $name = (string) ($data['Name'] ?? null);
        $email = (string) ($data['Email'] ?? null);
        $currentPassword = (string) ($data['Password'] ?? null);
        $newPassword = (string) ($data['newPassword'] ?? null);
        
        if($name!=null||$email!=null){
        $data = $this->staffUpdater->updateStaff($id,$name,$email);
        }
        if($newPassword!=null){
        $data = $this->staffUpdater->updatePassword($id,$currentPassword,$newPassword);
        }


        if ($data->success) {
            $status = $data->status;
            $result = [
                'success' => $data->success,
                'message' => $data->message
            ];
        } else {
            $status = $data->status;
            $result = [
                'success' => $data->success,
                'message' => $data->message
            ];
        }

        return $this->sendResponse($response, $result, $status);
    }

    private function sendResponse($response, $result, $status)
    {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string) json_encode($result));

        return $response->withStatus($status);
    }
}