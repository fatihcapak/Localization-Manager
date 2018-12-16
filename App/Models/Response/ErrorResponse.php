<?php
/**
 * Error Response Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Response;


class ErrorResponse extends ResponseAbstract
{
    public $status = false;

    /**
     * @var integer
     */
    public $code = 0;

    /**
     * @var string
     */
    public $message = 'Error';

    /**
     * @var string
     */
    public $title = 'Error';

    function __construct($code, $message, $title = null, $status = false)
    {
        $this->code = $code;
        $this->message = $message;
        $this->title = $title;
        $this->status = $status;
    }
}
