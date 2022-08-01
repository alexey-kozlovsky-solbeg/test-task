<?php
declare(strict_types=1);

namespace App\Exception;

class ListServiceException extends \Exception
{
    protected $message = 'ListService exception';

    protected $code = 0;
}
