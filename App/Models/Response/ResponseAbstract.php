<?php
/**
 * ResponseAbstract Model Class
 *
 * @copyright   Copyright (c) 2018 (https://github.com/fatihcapak/Localization-Manager)
 * @author      Fatih ÇAPAK
 */

namespace App\Models\Response;


abstract class ResponseAbstract implements ResponseInterface
{
    public $status;
    public $code;
    public $message;
}
