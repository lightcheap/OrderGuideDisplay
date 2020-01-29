<?php
/**
 * セッション関係
 */
class Session
{
    //セッションがスタートしているかどうかを
    // 静的チェックするためのプロパティ
    protected static $sessionStarted = false;
    //
    protected static $sessionIdRegenerated = false;

    private $array_ymd = array();

    public function __construct()
    {
        // セッションがスタートしてるかチェックする
        if (!self::$sessionStarted )
        {
            session_start();

            self::$sessionStarted = true;
        }

        //
    }

    //　セッションをセットするメソ
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    // セッションを取得するメソ。
    public function get($name, $default = null)
    {
        // セッション名が存在するなら返す
        if (isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
        //ないならデフォ＝nullを返す
        return $default;
    }

    // セッション名を開放するメソ
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    // セッションそのものを消すメソ
    public function clear()
    {
        $_SESSION = array();
    }

    //置き場所がわからないのでここにおいとく
    public function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
