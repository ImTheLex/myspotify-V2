<?php
class SessionManager {
    public static function setSession($key, $value) {
        if (session_status()  === PHP_SESSION_NONE){
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    public static function getSession($key) {
        if (session_status()  === PHP_SESSION_NONE){
            session_start();
        }
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        return $value;
    }

    public static function unsetSession($key) {
        if (session_status()  === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
