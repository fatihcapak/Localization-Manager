<?php
/**
 * Localization Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models;


class Localization
{
    const ITEM_PER_PAGE = 5;

    const LOCALIZATION_LIST_CACHE_ID = 'LocalizationList';
    const LOCALIZATION_LIST_CACHE_TTL = 300;

    public function getLocalizations($page)
    {
        $offset = ($page - 1) * static::ITEM_PER_PAGE;
        $limit = static::ITEM_PER_PAGE;

        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT L.id,
                               L.userid AS \"userId\",
                               P.value name,
                               LV.value AS \"localizationValueText\",
                               LK.value AS \"localizationKeyText\",
                               LANG.name language,
                               V.revision version
                        FROM localization L
                        INNER JOIN language LANG ON LANG.id = L.languageid
                        INNER JOIN localizationkey LK ON LK.id = L.localizationkeyid
                        INNER JOIN localizationvalue LV ON LV.id = L.localizationvalueid
                        INNER JOIN project P ON P.id = L.projectid
                        INNER JOIN version V ON V.id = L.versionid
                        LIMIT :limit
                        OFFSET :offset;");
        $select->bindParam(":limit", $limit, \PDO::PARAM_INT);
        $select->bindParam(":offset", $offset, \PDO::PARAM_INT);
        $select->execute();
        $select->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\Entities\Localization');

        return $select->fetchAll();
    }

    public function getLocalizationCount()
    {
        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT COUNT(id)
                        FROM localization;");
        $select->execute();

        return $select->fetch(\PDO::FETCH_COLUMN);
    }

    public function addLocalization(array $params)
    {
        try {
            \App\Models\Database\Connector::getInstance()->useMaster()->beginTransaction();

            if (isset($params['version']) && empty($params['versionId'])) {
                try {
                    $insert = \App\Models\Database\Connector::getInstance()
                        ->useMaster()
                        ->prepare("INSERT INTO version
                              (revision) VALUES (:revision);");
                    $insert->bindParam(":revision", $params['version']);
                    $insert->execute();

                    $versionId = \App\Models\Database\Connector::getInstance()->useMaster()->lastInsertId();
                } catch (\Exception $e) {
                    $select = \App\Models\Database\Connector::getInstance()
                        ->useMaster()
                        ->prepare("SELECT id FROM version WHERE revision = :revision");
                    $select->bindParam(":revision", $params['version']);
                    $select->execute();

                    $versionId = $select->fetch(\PDO::FETCH_COLUMN);
                }
            } else {
                $versionId = $params['versionId'];
            }

            if (isset($params['project']) && empty($params['projectId'])) {
                try {
                    $insert = \App\Models\Database\Connector::getInstance()
                        ->useMaster()
                        ->prepare("INSERT INTO project
                              (value) VALUES (:value);");
                    $insert->bindParam(":value", $params['project']);
                    $insert->execute();

                    $projectId = \App\Models\Database\Connector::getInstance()->useMaster()->lastInsertId();
                } catch (\Exception $e) {
                    $select = \App\Models\Database\Connector::getInstance()
                        ->useMaster()
                        ->prepare("SELECT id FROM project WHERE value = :value");
                    $select->bindParam(":value", $params['project']);
                    $select->execute();

                    $projectId = $select->fetch(\PDO::FETCH_COLUMN);
                }
            } else {
                $projectId = $params['projectId'];
            }

            $insert = \App\Models\Database\Connector::getInstance()
                ->useMaster()
                ->prepare("INSERT IGNORE INTO localizationkey
                              (value) VALUES (:value);");
            $insert->bindParam(":value", $params['key']);
            $insert->execute();

            $localizationKeyId = \App\Models\Database\Connector::getInstance()->useMaster()->lastInsertId();
            if (!$localizationKeyId) {
                $select = \App\Models\Database\Connector::getInstance()
                    ->useMaster()
                    ->prepare("SELECT id FROM localizationkey WHERE value = :value");
                $select->bindParam(":value", $params['key']);
                $select->execute();
                $localizationKeyId = $select->fetch(\PDO::FETCH_COLUMN);
            }

            $insert = \App\Models\Database\Connector::getInstance()
                ->useMaster()
                ->prepare("INSERT IGNORE INTO localizationvalue
                              (value) VALUES (:value);");
            $insert->bindParam(":value", $params['value']);
            $insert->execute();

            $localizationValueId = \App\Models\Database\Connector::getInstance()->useMaster()->lastInsertId();
            if (!$localizationValueId) {
                $select = \App\Models\Database\Connector::getInstance()
                    ->useMaster()
                    ->prepare("SELECT id FROM localizationvalue WHERE value = :value");
                $select->bindParam(":value", $params['value']);
                $select->execute();
                $localizationValueId = $select->fetch(\PDO::FETCH_COLUMN);
            }

            $insert = \App\Models\Database\Connector::getInstance()
                ->useMaster()
                ->prepare("INSERT INTO localization (projectid, localizationvalueid, languageid, localizationkeyid, versionid, userid)
                            VALUES (:projectId,
                                    :localizationValueId,
                                    :languageId,
                                    :localizationKeyId,
                                    :versionId,
                                    :userId);");
            $insert->bindParam(":projectId", $projectId);
            $insert->bindParam(":localizationValueId", $localizationValueId);
            $insert->bindParam(":languageId", $params['languageId']);
            $insert->bindParam(":localizationKeyId", $localizationKeyId);
            $insert->bindParam(":versionId", $versionId);
            $insert->bindValue(":userId", (new \App\Models\User())->getCurrentUser()->getId());
            $insert->execute();

            \App\Models\Database\Connector::getInstance()->useMaster()->commit();
        } catch (\Exception $e) {
            \App\Models\Database\Connector::getInstance()->useMaster()->rollBack();
            throw new \UnexpectedValueException("Inserting error");
        }
    }

    public function getLocale($projectName, $language, $version)
    {
        $cache = (new \App\Models\Cache\CacheFactory())->get(\App\Models\Cache\CacheFactory::CACHE_FILE);
        $cacheId = $cache->generateCacheKey(static::LOCALIZATION_LIST_CACHE_ID, $projectName, $language, $version);
        $cache->setCacheTtl(static::LOCALIZATION_LIST_CACHE_TTL);

        $result = $cache->load($cacheId);
        if ($result !== false) {
            //return $result;
        }

        $version = (float)$version;

        $select = \App\Models\Database\Connector::getInstance()
            ->useSlave()
            ->prepare("SELECT L.id,
                            LV.value AS \"valueText\",
                            LK.value AS \"keyText\",
                            LANG.name AS language,
                            P.value AS project,
                            V.revision AS version
                        FROM localization L
                        INNER JOIN language LANG ON L.languageid = LANG.id
                        INNER JOIN localizationkey LK ON L.localizationkeyid = LK.id
                        INNER JOIN localizationvalue LV ON L.localizationvalueid = LV.id
                        INNER JOIN project P ON P.id = L.projectid
                        INNER JOIN version V ON V.id = L.versionid
                        WHERE P.value = :projectName 
                          AND LANG.name = :language 
                          AND V.revision BETWEEN :version - 0.001 AND :version;");
        $select->bindParam(":projectName", $projectName);
        $select->bindParam(":language", $language);
        $select->bindParam(":version", $version, \PDO::PARAM_INT);
        $select->execute();

        $result = $select->fetchAll(\PDO::FETCH_ASSOC);
        $cache->save($result, $cacheId);

        return $result;
    }
}
