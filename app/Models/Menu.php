<?php

namespace App\Models;

use App\Models\Driver\Engine;

class Menu
{

    use Traits\BaseFunctions;

    const CONNECTION_NAME = 'framework';


    public static function getConnection()
    {
        return Engine::getConnection(self::CONNECTION_NAME);
    }

    public static function create($data = array())
    {

    }


    public static function getMenu()
    {
        $connection = self::getConnection();

        $query = "SELECT * FROM menu WHERE menu.blocked ='0'";

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    public static function getSubMenu()
    {

        $connection = self::getConnection();

        $query = "SELECT * FROM sub_menu WHERE sub_menu.blocked ='0'";

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

    public static function getSubMenuUsers()
    {

        $connection = self::getConnection();

        $query = "SELECT sub_menu.`title`, sub_menu.`title_url`, sub_menu.`img`, sub_menu.`blocked` FROM sub_menu, menu WHERE sub_menu.menu_id = menu.`menu_id` AND menu.`title` = 'Configuration'";

        $statement = $connection->prepare($query);

        $success = $statement->execute();

        if ($success) {
            return $statement->fetchAll();
        }

        return false;
    }

}
