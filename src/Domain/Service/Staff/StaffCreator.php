<?php

namespace App\Domain\Service\Staff;

use app\Domain\Repository\StaffRepository;

final class StaffCreator
{
    private $staffRepo;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    public function create(string $name, string $email, string $password)
    {
        try {
            $staff = $this->staffRepo->getStaffByEmail($email);
            if ($staff == null) {
                // $rawPassword = 'IRB123';

                $this->staffRepo->createStaff($name, $email, $password);

                $response = (object) [
                    'status' => 201,
                    'success' => true,
                    'message' => 'Registration was successful.'
                ];
                return $response;
            } else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Email already exists.'
                ];
                return $response;
            }
        } catch (\Exception $e) {
            $response = (object) [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage() //for internal server error
            ];
            return $response;
        }
    }
}
