<?php

namespace App\Domain\Service\Staff;
use App\Domain\Repository\StaffRepository;

final class StaffUpdater
{
    private $staffRepo;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    public function updateStaff(
        int $id,
        string $name = null,
        string $email
        //changes bole jd null (eg: nk tukar nama sahaja)
    ) {
        try {
            $staff = $this->staffRepo->getStaffById($id);
            if ($email != null) {
                if ($email != $staff['Email']) {
                    $staffEmail = $this->staffRepo->getStaffByEmail($email);
                    if ($staffEmail != null) {
                        $response = (object) [
                            'status' => 200,
                            'success' => false,
                            'message' => 'Email already exists.'
                        ];
                        return $response;
                    }
                }
            }

            // if ($newPassword != null) {
            //     if (password_verify($password, $staff['Password'])) { 
            //         $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);   
            //     }
            //     else {
            //         $response = (object) [
            //             'status' => 200,
            //             'success' => false,
            //             'message' => 'Password mismatch.'
            //         ];
            //         return $response;
            //     }
            // } else {
            //     $hashPassword = null;
            // }

            $this->staffRepo->updateStaff($id,$name,$email,null,null);

            $response = (object) [
                'status' => 200,
                'success' => true,
                'message' => 'Update staff was successful.'
            ];
            return $response;
        } catch (\Exception $e) {
            $response = (object) [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }

    public function updatePassword(
        int $id,
        string $currentPassword = null,
        string $newPassword = null
    ) {
        try {
            if ($newPassword != null && $currentPassword != null) {
                $staff = $this->staffRepo->getStaffById($id);
                if (password_verify($currentPassword, $staff['Password'])) {
                    $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                } else {
                    $response = (object) [
                        'status' => 200,
                        'success' => false,
                        'message' => 'Current password is wrong.'
                    ];
                    return $response;
                }
            } else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Current password and new password are required to update the password.'
                ];
                return $response;
            }

            $this->staffRepo->updateStaff($id, null, null, $newPassword, null);

            $response = (object) [
                'status' => 200,
                'success' => true,
                'message' => 'Update password was successful.'
            ];
            return $response;
        } catch (\Exception $e) {
            $response = (object) [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }

    public function updateToken(
        int $id,
        string $token
    ) {
        try {
            $this->staffRepo->updateStaff($id, null, null, null, $token);

            $response = (object) [
                'status' => 200,
                'success' => true,
                'message' => 'Update token was successful.'
            ];
            return $response;
        } catch (\Exception $e) {
            $response = (object) [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }
}
