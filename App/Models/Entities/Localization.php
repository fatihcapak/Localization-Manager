<?php

namespace App\Models\Entities;


class Localization
{
    protected $id;
    protected $userId;
    protected $name;
    protected $language;
    protected $version;
    protected $localizationKeyText;
    protected $localizationValueText;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getLocalizationKeyText()
    {
        return $this->localizationKeyText;
    }

    /**
     * @param mixed $localizationKeyText
     */
    public function setLocalizationKeyText($localizationKeyText)
    {
        $this->localizationKeyText = $localizationKeyText;
    }

    /**
     * @return mixed
     */
    public function getLocalizationValueText()
    {
        return $this->localizationValueText;
    }

    /**
     * @param mixed $localizationValueText
     */
    public function setLocalizationValueText($localizationValueText)
    {
        $this->localizationValueText = $localizationValueText;
    }
}
