<?php
/**
 * いちいちrequireを使わなくてもクラスをつかえる
 * ようにする
 */
// ClassLoader.phpよびだし
require( $_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/core/ClassLoader.php');

// クラスローダーのインスタンス
$loader = new ClassLoader;

//オートロードするディレクトリを指定する。
//登録先は配列だから、いくつでも登録は可能。
$loader->registerDir( dirname(__FILE__) . '/core');
//上で指定したディレクトリを呼び出す。
$loader->register();

session_set_cookie_params(time()+60*60*2, '/yakiniku2/');
// セッションのインスタンス
$session = new Session;

// エラーを表示。本番のときはけすよ
ini_set('display_errors', 1);

