<?php
// ユーザーのリクエストを制御するクラス。
class Request
{
    //リクエストがPOSTかどうかを静的に判定する
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            return true;
        }
        return false;
    }

    //リクエストがGETかどうかを静的に判定する
    public function isGet()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            return true;
        }
        return false;
    }

    // $_GETから値を取得する。ここはもっとセキュリティ高めないとだめ
    public function getGet($name, $default = null)
    {
        if (isset($_GET[$name]))
        {
            return $_GET[$name];
        }

        return $default;
    }

    // $_POSTから値を取得する。ここはもっとセキュリティ高めないとだめ
    public function getPost($name, $default = null)
    {
        if (isset($_POST[$name]) || strlen($_POST[$name]))
        {
            return $_POST[$name];
        }
        else
        {
            return $default;
        }

    }

    // サーバーのホスト名を取得する。
    public function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST']))
        {
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SERVER_NAME'];
    }

    public function isSsl()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        {
            return true;
        }
        return false;
    }

    // リクエストしたURLの情報は$_SERVER['REQUEST_URI']に格納されるので、
    //その値をそのまま返す。
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI']; //実際urlバーに表示される、ホストより先のURL値
    }

    // ベースURLとPATH_INFOを取得する
    public function getBaseUrl()
    {
        $script_name = $_SERVER['SCRIPT_NAME']; //ホストからフロントコントローラーまでの値

        $request_uri = $this->getRequestUri();

        //
        if (0 === strpos($request_uri, $script_name))
        {
            return $script_name;
        }
        elseif (0 === strpos($request_uri, dirname($script_name)))
        {
            return rtrim( dirname($script_name), '/');
        }
        return '';
    }

    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if (false !== ($pos = strpos($request_uri, '?')))
        {
            $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
    }

    // リダイレクト
    public function redirect($url)
    {
        header('Location:'.'https://'.$_SERVER['HTTP_HOST'] . $url, true, 301);
    }

    //リファラー用
    function referer($url)
    {
        header('Location:'. $url, true, 301);
    }
}