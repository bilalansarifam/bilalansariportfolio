<?php
/**
 * PHPMailer - PHP email creation and transport class.
 * Updated Version — Clean and Compatible with PHP 8+
 *
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer
 */

namespace PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * PHPMailer main class
 */
class PHPMailer
{
    public $Host = 'localhost';
    public $Port = 25;
    public $SMTPSecure = '';
    public $SMTPAuth = false;
    public $Username = '';
    public $Password = '';
    public $From = '';
    public $FromName = '';
    public $Subject = '';
    public $Body = '';
    public $AltBody = '';
    public $isHTML = false;
    public $SMTPDebug = 0;
    public $Debugoutput = 'echo';
    public $ErrorInfo = '';
    public $CharSet = 'UTF-8';

    protected $mail;
    protected $smtp;

    public function __construct($exceptions = false)
    {
        $this->exceptions = $exceptions;
    }

    /**
     * Enable SMTP for sending mail
     */
    public function isSMTP()
    {
        $this->Mailer = 'smtp';
        $this->smtp = new SMTP();
    }

    /**
     * Set email format to HTML or plain text
     */
    public function isHTML($isHTML = true)
    {
        $this->isHTML = $isHTML;
    }

    /**
     * Set sender email and name
     */
    public function setFrom($address, $name = '')
    {
        $this->From = $address;
        $this->FromName = $name;
    }

    /**
     * Add recipient address
     */
    public function addAddress($address, $name = '')
    {
        $this->to[] = ['email' => $address, 'name' => $name];
    }

    /**
     * Add reply-to address
     */
    public function addReplyTo($address, $name = '')
    {
        $this->ReplyTo = ['email' => $address, 'name' => $name];
    }

    /**
     * Send email via SMTP
     */
    public function send()
    {
        try {
            // Validate essential data
            if (empty($this->Host) || empty($this->Username) || empty($this->Password)) {
                throw new Exception('SMTP configuration is incomplete.');
            }

            // Use PHP’s mail() if SMTP not configured
            if ($this->Mailer !== 'smtp') {
                $headers = "From: {$this->FromName} <{$this->From}>\r\n";
                $headers .= "Reply-To: {$this->ReplyTo['name']} <{$this->ReplyTo['email']}>\r\n";
                $headers .= "Content-Type: " . ($this->isHTML ? "text/html" : "text/plain") . "; charset=UTF-8\r\n";
                return mail($this->to[0]['email'], $this->Subject, $this->Body, $headers);
            }

            // Send using SMTP
            $this->smtp = new SMTP();
            $this->smtp->do_debug = $this->SMTPDebug;
            $this->smtp->Debugoutput = $this->Debugoutput;
            $this->smtp->connect($this->Host, $this->Port);
            $this->smtp->hello(gethostname());
            $this->smtp->authenticate($this->Username, $this->Password);

            // Build headers
            $headers  = "From: {$this->FromName} <{$this->From}>\r\n";
            $headers .= "Reply-To: {$this->ReplyTo['name']} <{$this->ReplyTo['email']}>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: " . ($this->isHTML ? "text/html" : "text/plain") . "; charset={$this->CharSet}\r\n";

            // Send email
            $result = $this->smtp->data("To: {$this->to[0]['email']}\r\nSubject: {$this->Subject}\r\n{$headers}\r\n\r\n{$this->Body}");
            $this->smtp->quit();
            $this->smtp->close();

            return $result;
        } catch (Exception $e) {
            $this->ErrorInfo = $e->getMessage();
            if ($this->exceptions) {
                throw $e;
            }
            return false;
        }
    }
}
?>
