<?php

namespace App\Helpers\Classes;


use App\Helpers\Enums\AdminMessageType;

/**
 * AdminMessage is a class to display messages at the top of the admin dashboard
 */
final class AdminMessage
{

    private array $messages;

    public function __construct(Hook $hook)
    {
        $this->messages = array();
        $hook->add("admin_messages", array($this, 'get'));
    }

    public function add(string $content, AdminMessageType $type = AdminMessageType::Info): void
    {
        $this->messages[] = array(
            "content" => $content,
            "type" => $type
        );
    }

    public function get(): void
    {
        $result = "<div>";
        foreach ($this->messages as $message) {
            $type = "info";
            switch ($message["type"]) {
                case AdminMessageType::Success:
                    $type = "success";
                    break;
                case AdminMessageType::Warning:
                    $type = "warning";
                    break;
                case AdminMessageType::Danger:
                    $type = "danger";
            }
            $result .= '
            <div class="alert alert-'. $type .' alert-dismissible fade show" role="alert">
                <span>' . $message["content"] . '</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        $result .= "</div>";
        echo $result;
    }

}
