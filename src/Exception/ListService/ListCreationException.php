<?php
declare(strict_types=1);

namespace App\Exception\ListService;

use App\Exception\ListServiceException;

class ListCreationException extends ListServiceException
{
    protected $message = 'List creation error';

    protected $code = 2;
}
