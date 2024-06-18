<?php

namespace App\Domain\Service\Student;

use App\Domain\Repository\StudentRepository;

final class StudentDeleter
{
    private $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function deleteStudent(int $id)
    {
        if ($this->studentRepo->deleteStudent($id) > 0) {
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
