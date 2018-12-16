<?php
/**
 * Version Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;


class Version
{
    public function getAllVersion()
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT * FROM version;");
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }
}
