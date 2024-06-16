<?php

namespace App\Http\Controllers;

use App\Traits\ResponseSender;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ResponseSender;
}
