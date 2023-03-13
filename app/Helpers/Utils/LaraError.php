<?php

namespace App\Helpers\Utils;

class LaraError
{
    private static array $errors = array();
    private string $code;
    private string $message;

    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
        $this->Add($code, $message);
    }

    /**
     * @param string $code
     * @param string $message
     * @return void
     */
    private function Add(string $code, string $message): void
    {
        self::$errors[$code][] = $message;
    }

    /**
     * @param string $code
     * @return void
     */
    public static function Remove(string $code): void {
        unset(self::$errors[$code]);
    }

    /**
     * @return bool
     */
    public function HasErrors(): bool
    {
        return !empty(self::$errors);
    }

    /**
     * @return string
     */
    public function GetCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function GetMessage(): string {
        return $this->message;
    }

    /**
     * @param string $code
     * @return string|false
     */
    public static function GetError(string $code): string|false {
        if (empty($code)) return false;
        if (array_key_exists($code, self::$errors)) return self::$errors[$code];
        return false;
    }

}
