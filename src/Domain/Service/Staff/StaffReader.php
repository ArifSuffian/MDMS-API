<?php

namespace App\Domain\Service\Staff;
use App\Domain\Repository\staffRepository;

final class StaffReader
{
    private $staffRepo;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    public function getAllStaffs()
    {
        $staffs = $this->staffRepo->getAllStaff();
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'staffs' => $staffs
            ]
        ];

        return $response;
    }

    public function getStaffById(int $id)
    {
        $staff = $this->staffRepo->getStaffById($id);
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'staff' => $staff
            ]
        ];

        return $response;
    }
}