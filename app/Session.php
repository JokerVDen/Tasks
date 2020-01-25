<?php


namespace App;


use EasyCSRF\Interfaces\SessionProvider;

class Session implements SessionProvider
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    /**
     * @var bool The state of the session
     */
    private $sessionState = self::SESSION_NOT_STARTED;

    private static $instance;


    private function __construct()
    {
    }

    /**
     * Returns THE instance of 'Session'.
     * The session is automatically initialized if it wasn't.
     *
     * @return Session
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }


    /**
     * (Re)starts the session.
     *
     * @return bool TRUE if the session has been initialized, else FALSE.
     **/

    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }


    /**
     * Stores datas in the session.
     * Example: $instance->foo = 'bar';
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }


    /**
     * Gets datas from the session.
     * Example: echo $instance->foo;
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }


    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }


    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }


    /**
     *    Destroys the current session.
     *
     * @return    bool    TRUE is session has been deleted, else FALSE.
     **/

    public function destroy()
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return FALSE;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}