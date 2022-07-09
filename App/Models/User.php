<?php
/**
 * User Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;


class User
{
    const ITEM_PER_PAGE = 10;

    /**
     * @return \App\Models\Entities\User
     */
    public function getCurrentUser()
    {
        return !empty($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    /**
     * @param $username
     * @return \App\Models\Entities\User|null
     */
    public function getUserByUsername($username)
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT * 
                      FROM user 
                      WHERE username = :username;");
        $select->bindParam(":username", $username);
        $select->execute();
        $select->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Entities\User');
        return $select->fetch();
    }

    public function login($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user instanceof \App\Models\Entities\User && $user->getPassword() === md5($password)) {
            $_SESSION['user'] = $user;
            return $user;
        }

        return false;
    }

    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }

    public function getUsers($page = 1)
    {
        $offset = ($page - 1) * static::ITEM_PER_PAGE;
        $limit = static::ITEM_PER_PAGE;

        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT *
                      FROM user
                      LIMIT :limit OFFSET :offset;");
        $select->bindParam(":limit", $limit, \PDO::PARAM_INT);
        $select->bindParam(":offset", $offset, \PDO::PARAM_INT);
        $select->execute();
        $select->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Entities\User');

        return $select->fetchAll();
    }

    public function getUserCount()
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT COUNT(id)
                      FROM user;");
        $select->execute();

        return $select->fetch(\PDO::FETCH_COLUMN);
    }

    public function addUser($username, $password, $role)
    {
        $insert = \App\Models\Database\Connector::getInstance()
            ->useMaster()
            ->prepare("INSERT INTO user 
                      (username, password, role)
                      VALUES (:username, :password, :role);");
        $insert->bindParam(":username", $username);
        $insert->bindValue(":password", md5($password));
        $insert->bindParam(":role", $role, \PDO::PARAM_INT);
        $insert->execute();

        return true;
    }

    public function updateUser($id, $username, $password, $role)
    {
        $insert = \App\Models\Database\Connector::getInstance()
            ->useMaster()
            ->prepare(sprintf("UPDATE user 
                      SET username = :username, role = :role%s
                      WHERE id = :id;", ($password ? ', password = :password' : '')));
        $insert->bindParam(":id", $id);
        $insert->bindParam(":username", $username);
        $insert->bindParam(":role", $role, \PDO::PARAM_INT);
        if ($password) {
            $insert->bindValue(":password", md5($password));
        }

        $insert->execute();

        return true;
    }
}
