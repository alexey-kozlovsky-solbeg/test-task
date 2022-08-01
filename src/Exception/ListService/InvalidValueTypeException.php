<?php
declare(strict_types=1);

namespace App\Exception\ListService;

use App\Exception\ListServiceException;

class InvalidValueTypeException extends ListServiceException
{
    protected $message = 'Invalid value type';

    protected $code = 1;
}
