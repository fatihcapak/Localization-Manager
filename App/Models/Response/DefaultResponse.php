<?php
/**
 * Response Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Response;


class DefaultResponse extends ResponseAbstract
{
    /**
     * @var boolean
     */
    public $status = true;

    /**
     * @var int
     */
    public $code = 0;

    /**
     * @var string
     */
    public $message = null;

    /**
     * @var array
     */
    public $data = [];

    function __construct($data, $status = true, $code = 0, $message = null)
    {
        $this->data = $data;
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
    }
}
