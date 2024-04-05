<?php

namespace App\Action\Staff;
use App\Domain\Repository\StaffRepository;

final class StaffDeleter
{
    private $staffRepo;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    public function deleteStaff(int $id)
    {
        if ($this->staffRepo->deleteStaff($id) > 0) {
            $response = (object) [
                'status' => 200,
                'success' => true,
                'message' => null
            ];
        } else {
            $response = (object) [
                'status' => 500,
                'success' => true,
                'message' => 'An error occured.'
            ];
        }

        return $response;
    }
}