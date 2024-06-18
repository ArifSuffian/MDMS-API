<?php

namespace App\Domain\Repository;

use Doctrine\DBAL\Connection;

class StudentRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    //id tk perlu declare (letak autoincre) 
    public function createStudent( string $name, string $email, string $password ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->insert('student')
            ->values(
                array(
                    'Name' => '?',
                    'Email' => '?',
                    'Password' => '?'
                )
            )
            ->setParameter(0, $name)
            ->setParameter(1, $email)
            ->setParameter(2, $password);

        $rows = $query->executeStatement(); //execute to database

        return $this->connection->lastInsertId();
    }

    public function getAllStudent()
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                's.Id',
                's.Name',
                's.Email'
            )
            ->from('student', 's') //from the staff table and then the s is the shortcut
            // ->leftJoin('s', 'employment_status', 'es', 's.EmploymentStatus_Id = es.Id')  
            //            shortcutcurrent  ,table yg nk join,  shortcut table nk join, variable = id of tht label  ko tgk jela irb tu 
            ->orderBy('Name');// arrange by name

        return $rows->fetchAllAssociative();
    }

    public function getStudentById(int $id)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                's.Id',
                's.Name',
                's.Email',
                's.Password',
                's.AuthToken'
            )
            ->from('staff', 's')
            // ->leftJoin('s', 'employment_status', 'es', 'e.EmploymentStatus_Id = es.Id')
            ->where('s.Id = :id')
            ->setParameter('id', $id);

        return $rows->fetchAssociative();
    }

    public function getStudentByEmail(string $email)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                's.Id',
                's.Name',
                's.Email',
                's.Password',
                's.AuthToken'
            )
            ->from('student', 's')
            // ->leftJoin('s', 'employment_status', 'es', 'e.EmploymentStatus_Id = es.Id')
            ->where('s.Email = :email') 
            ->setParameter('email', $email);

        return $rows->fetchAssociative();
    }

    public function getStudentByName(string $name)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                's.Id',
                's.Name',
                's.Email',
                's.Password',
                's.AuthToken'
            )
            ->from('student', 's')
            // ->leftJoin('s', 'employment_status', 'es', 'e.EmploymentStatus_Id = es.Id')
            ->where('s.Name = :name') 
            ->setParameter('name', $name);

        return $rows->fetchAssociative();
    }

    public function getStudentByAuthToken(string $token)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                's.Id',
                's.Name',
                's.Email',
                's.Password',
                's.AuthToken'
            )
            ->from('staff', 's')
            // ->leftJoin('e', 'employment_status', 'es', 'e.EmploymentStatus_Id = es.Id')
            ->where('s.AuthToken = :token')
            ->setParameter('token', $token);

        return $rows->fetchAssociative();
    }

    public function updateStudent(
        int $id,
        string $name = null,
        string $email = null,
        string $password = null,
        string $authToken = null,
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->update('staff')  //nama table 
            ->where('Id = :id')
            ->setParameter('id', $id);

        if ($name != null) {
            $query->set('Name', ':name')->setParameter('name', $name);
        }
        if ($email != null) {
            $query->set('Email', ':email')->setParameter('email', $email);
        }
        if ($password != null) {
            $query->set('Password', ':password')->setParameter('password', $password);
        }
        if ($authToken != null) {
            $query->set('AuthToken', ':authToken')->setParameter('authToken', $authToken);
        }

        $rows = $query->executeStatement();

        return $rows > 0;
    }

    public function deleteStudent(
        int $id
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->delete('staff')
            ->where('Id = :id')
            ->setParameter('id', $id);

        // $query->set('EmploymentStatus_Id', ':employmentStatusId')->setParameter('employmentStatusId', EMPLOYMENT_STATUS_TERMINATE);

        $rows = $query->executeStatement();

        return $rows > 0;
    }
}