<?php

namespace App\Models;

use App\Models\Driver\Engine;

class User
{

    use Traits\BaseFunctions;

    const SALT              = 'rsextr$ytf%ugiy878trdryktfulygi9o8r';
    const CONNECTION_NAME   = 'framework';
    const TABLE_NAME  = 'users';



    public static function getConnection()
    {
        return Engine::getConnection(self::CONNECTION_NAME);
    }

    public static function index($params = array())
    {
        $connection = self::getConnection();

        $limit = isset($params['Limit']) ? " LIMIT $params[Limit] " : '';
        $order = isset($params['SortField']) && isset($params['SortOrder']) ?
            " ORDER BY $params[SortField] $params[SortOrder] " : '';

        $query = "SELECT * FROM ".self::TABLE_NAME.$order.$limit;

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }



    public static function create($data = array())
    {
        $connection = self::getConnection();

        $name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $password = isset($data['password']) ? $data['password'] : '';

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                name,
                email,
                password
                
                
            ) VALUES (
                :name,
                :email,
                :password
                
            )"
        );

        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);


        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    public static function UserAdd($data = array())
    {
        $connection = self::getConnection();

        $name = isset($data['name']) ? $data['name'] : '';
        $login = isset($data['login']) ? $data['login'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $password = isset($data['password']) ? self::getPassHash($data['password']) : '';
        $blocked = isset($data['blocked']) ? $data['blocked'] : '';

        $statement = $connection->prepare(
            " INSERT INTO ".self::TABLE_NAME."(
                name,
                login,
                email,
                password,
                blocked
                
            ) VALUES (
                :name,
                :login,
                :email,
                :password,
                :blocked
            )"
        );

        $statement->bindValue(':name', $name);
        $statement->bindValue(':login', $login);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':blocked', $blocked);

        $inserted = $statement->execute();

        if ($inserted) {
            return $connection->lastInsertId(self::TABLE_NAME);
        }

        return false;
    }

    public static function update($id, array $data)
    {
        $connection = self::getConnection();

        $name = isset($data['name']) ? $data['name'] : '';
        $login = isset($data['login']) ? $data['login'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $password = isset($data['password']) ? self::getPassHash($data['password']) : '';
        $blocked = isset($data['blocked']) ? $data['blocked'] : '';

        $statement = $connection->prepare(
            "UPDATE ".self::TABLE_NAME."
             SET
                name = :name,
                login = :login,
                email = :email,
                password = :password,
                blocked = :blocked
                
             WHERE id = :id"
        );


        $statement->bindValue(':name', $name);
        $statement->bindValue(':login', $login);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':blocked', $blocked);

        return $statement->execute();
    }

    public static function auth($params = array())
    {
        $connection = self::getConnection();

        $email = $params['email'];

        $query = "SELECT * FROM ".self::TABLE_NAME . " WHERE email = :email";


        $statement = $connection->prepare($query);

        $statement->bindValue('email', $email);

        $success = $statement->execute();

        if ($success) {
            $result =  $statement->fetchAll();
        }

        if (isset($result[0]['password']) && !empty($result[0]['password'])) {
            $userPass = self::getPassHash($params['password']);

            if ($userPass === $result[0]['password']) {
                return true;
            }
        }

        return false;
    }

    public static function delete($data = array())
    {
        $connection = self::getConnection();

        $ids = isset($data['Id']) && is_array($data['Id'])
            ? $data['Id']
            : [];

        $whereInds = '';
        foreach ($ids as $n => $id) {
            $whereInds .= $n ? ',' : '';
            $whereInds .= ":id_$n";
        }

        $whereInds = $whereInds ? " id IN ($whereInds) " : '';

        if (!$whereInds) {
            return false;
        }

        $statement = $connection->prepare(
            "DELETE FROM ".self::TABLE_NAME." WHERE $whereInds"
        );

        foreach ($ids as $n => $id) {
            $statement->bindValue(":id_$n", $id);
        }

        return $statement->execute();
    }

    public static function selectOne($data = array())
    {
        $connection = self::getConnection();

        $id = isset($data['Id']) ? $data['Id'] : '';

        $statement = $connection->prepare(
            "SELECT *
                FROM ".self::TABLE_NAME."
            WHERE id = :id"
        );

        $statement->bindValue(':id', $id);

        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }

    public static function getPassHash($password)
    {
        return md5($password . self::SALT);
    }

}
