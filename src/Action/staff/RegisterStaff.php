<?php

namespace App\Action\Staff;
use App\Domain\Service\Staff\StaffCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class RegisterStaff
{
    private $staffCreatorService;

    public function __construct(StaffCreator $staffCreatorService)
    {
        $this->staffCreatorService = $staffCreatorService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $status = null;
        $data = (array) $request->getParsedBody(); //From JSON body

        $name = (string) ($data['Name'] ?? null); //front end variable must same capital
        $email = (string) ($data['Email'] ?? null);
        $password = (string) ($data['Password'] ?? null);
       
       

        if (empty($email)) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'email is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }
        if (empty($name)) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Name is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }
        if (empty($password)) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Password is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }
        

        $data = $this->staffCreatorService->create($name,$email,$password);
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