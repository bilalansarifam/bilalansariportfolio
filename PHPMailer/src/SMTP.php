<?php
/**
 * PHPMailer SMTP class
 * Updated lightweight version — PHP 8+ compatible
 *
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer
 */

namespace PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

/**
 * Handles SMTP connections and communication.
 */
class SMTP
{
    public $do_debug = 0;          // Debug level: 0 = off, 1 = commands, 2 = data, 3 = connection
    public $Debugoutput = 'echo';  // How to output debug messages
    public $Timeout = 30;          // Connection timeout (seconds)
    public $smtp_conn = null;      // The SMTP connection resource
    public $error = [];            // Error messages
    public $last_reply = '';       // Last reply from the server

    /**
     * Connect to the SMTP server
     */
    public function connect($host, $port = 25, $timeout = 30)
    {
        $this->smtp_conn = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$this->smtp_conn) {
            throw new Exception("SMTP Connection Failed: $errstr ($errno)");
        }

        $this->server_info = $this->get_lines();
        if ($this->do_debug > 0) {
            $this->edebug("Connected to SMTP server: $host:$port");
        }

        return true;
    }

    /**
     * Say hello (HELO/EHLO)
     */
    public function hello($hostname)
    {
        $this->send_command('EHLO', $hostname);
    }

    /**
     * Authenticate with SMTP server
     */
    public function authenticate($username, $password)
    {
        $this->send_command('AUTH LOGIN');
        $this->send_command(base64_encode($username));
        $this->send_command(base64_encode($password));
    }

    /**
     * Send data (MAIL, RCPT, DATA)
     */
    public function data($message)
    {
        $this->send_command('MAIL FROM: <no-reply@example.com>');
        $this->send_command('RCPT TO: <recipient@example.com>');
        $this->send_command('DATA');
        $this->client_send($message . "\r\n.");
        return $this->get_lines();
    }

    /**
     * Quit and close the connection
     */
    public function quit()
    {
        $this->send_command('QUIT');
    }

    public function close()
    {
        if ($this->smtp_conn) {
            fclose($this->smtp_conn);
            $this->smtp_conn = null;
            if ($this->do_debug > 0) {
                $this->edebug("SMTP connection closed.");
            }
        }
    }

    /**
     * Send a raw SMTP command
     */
    protected function send_command($command, $args = '')
    {
        if (!$this->smtp_conn) {
            throw new Exception('No SMTP connection available.');
        }

        $full_command = $args ? "$command $args" : $command;
        $this->client_send($full_command . "\r\n");

        $response = $this->get_lines();
        if ($this->do_debug > 1) {
            $this->edebug("Command: $full_command\nResponse: $response");
        }

        return $response;
    }

    /**
     * Read lines from the SMTP server
     */
    protected function get_lines()
    {
        if (!$this->smtp_conn) {
            return '';
        }

        $data = '';
        while ($str = fgets($this->smtp_conn, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == ' ') {
                break;
            }
        }
        $this->last_reply = $data;
        return $data;
    }

    /**
     * Send data to SMTP server
     */
    protected function client_send($data)
    {
        fwrite($this->smtp_conn, $data);
        if ($this->do_debug > 2) {
            $this->edebug(">> $data");
        }
    }

    /**
     * Display debug info
     */
    protected function edebug($str)
    {
        if ($this->Debugoutput === 'html') {
            echo htmlspecialchars($str) . "<br>";
        } elseif ($this->Debugoutput === 'error_log') {
            error_log($str);
        } else {
            echo $str . "\n";
        }
    }
}
?>
