<?php

namespace App\Domain\Service\Student;
use App\Domain\Repository\studentRepository;

final class StudentReader
{
    private $studentRepo;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function getAllStudents()
    {
        $students = $this->studentRepo->getAllStudent();
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'students' => $students
            ]
        ];

        return $response;
    }

    public function getStudentById(int $id)
    {
        $student = $this->studentRepo->getStudentById($id);
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'student' => $student
            ]
        ];

        return $response;
    }
}