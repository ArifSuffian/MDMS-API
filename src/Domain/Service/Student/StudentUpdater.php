<?php

namespace App\Domain\Service\Student;
use App\Domain\Repository\StudentRepository;

final class StudentUpdater
{
    private $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function updateStudent(
        int $id,
        string $name = null,
        string $email
        //changes bole jd null (eg: nk tukar nama sahaja)
    ) {
        try {
            $student = $this->studentRepo->getStudentById($id);
            if ($email != null) {
                if ($email != $student['Email']) {
                    $studentEmail = $this->studentRepo->getStudentByEmail($email);
                    if ($studentEmail != null) {
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
            //     if (password_verify($password, $student['Password'])) { 
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

            $this->studentRepo->updateStudent($id,$name,$email,null,null);

            $response = (object) [
                'status' => 200,
                'success' => true,
                'message' => 'Update student was successful.'
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
                $student = $this->studentRepo->getStudentById($id);
                if (password_verify($currentPassword, $student['Password'])) {
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

            $this->studentRepo->updateStudent($id, null, null, $newPassword, null);

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
            $this->studentRepo->updateStudent($id, null, null, null, $token);

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
