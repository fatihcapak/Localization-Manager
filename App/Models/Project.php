<?php
/**
 * Project Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;

class Project
{
    public function getAllProject()
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT * FROM project;");
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }
}
