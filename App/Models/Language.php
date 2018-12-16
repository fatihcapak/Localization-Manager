<?php
/**
 * Language Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;


class Language
{
    public function getAllLanguage()
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT * FROM language;");
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }
}
