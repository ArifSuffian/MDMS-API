<?php

namespace App\Domain\Service;

use App\Domain\Repository\StaffRepository;

final class Authenticator
{
    private $staffRepo;
    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    public function authenticate(string $email, string $password)
    {
        $staff = $this->staffRepo->getStaffByEmail($email);
        if ($staff != null) {
            if (password_verify($password, $staff['Password'])) {

                $token = bin2hex(openssl_random_pseudo_bytes(8));
                $this->staffRepo->updateStaff($staff['Id'], null, null, null, $token);
                $staff['AuthToken'] = $token;

                $response = (object) [
                    'success' => true,
                    'message' => null,
                    'records' => (object) [
                        'user' => (object) [
                            'Id' => $staff['Id'],
                            'Name' => $staff['Name'],
                            'Email' => $staff['Email'],
                            'AuthToken' => $staff['AuthToken']
                        ]
                    ]
                ];

                return $response;
            } else {
                $response = (object) [
                    'success' => false,
                    'message' => 'Incorrect email/password.'
                ];
                return $response;
            }

        } else {
            $response = (object) [
                'success' => false,
                'message' => 'Incorrect email/password.'
            ];
            return $response;
        }
    }

    public function validateToken(string $accessToken): bool
    {
        $user = $this->staffRepo->getStaffByAuthToken($accessToken);
        return $user != null;
    }
}