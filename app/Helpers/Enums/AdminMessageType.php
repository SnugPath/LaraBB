<?php

namespace App\Helpers\Enums;

enum AdminMessageType: string
{
    case Info = "info";
    case Success = "success";
    case Warning = "warning";
    case Danger = "danger";
}
