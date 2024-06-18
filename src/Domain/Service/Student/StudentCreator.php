<?php

namespace App\Domain\Service\Student;
use App\Domain\Repository\StudentRepository;

final class StudentCreator
{
    private $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function create(string $name,string $email, string $password)
    {
        try {
            $student = $this->studentRepo->getStudentByEmail($email);
            if ($student == null) {
                    // $rawPassword = 'IRB123';
                    
                    $this->studentRepo->createStudent($name, $email, $password);

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
