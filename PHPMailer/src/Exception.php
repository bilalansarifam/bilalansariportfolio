<?php
/**
 * PHPMailer Exception class
 * PHP Version 7.0+
 *
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer
 */

namespace PHPMailer\PHPMailer;

/**
 * PHPMailer exception handler.
 * Provides simple and clean error messages.
 */
class Exception extends \Exception
{
    /**
     * Return formatted error message.
     *
     * @return string The formatted error message.
     */
    public function errorMessage()
    {
        return '<strong>Error:</strong> ' . htmlspecialchars($this->getMessage());
    }
}
?>
