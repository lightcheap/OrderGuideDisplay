<?php
/**
 * クラスを呼び出した際に、
 * 自動でファイルの読み込みをやってくれるようにする
 * 処理
 */
class ClassLoader
{
    protected $dirs;

    // オートローダークラスを登録する
    public function register()
    {
        // 'loadClass'でloadClass()を呼び出す。（コールバック関数）
        spl_autoload_register( array($this, 'loadClass') );
    }

    /**クラスファイルを読み込むファイルを探すメソ。
     * このメソの引数にオートロード対象のディレクトリの
     * フルパスを入れる。
     * それが$dirsにはいる
     */
    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    public function loadClass($class)
    {
        foreach ($this->dirs as $dir)
        {
            // 例） https://exactly-good.work/hoge/huga/.../class.php
            // みたいなこと
            $file = $dir . '/' . $class . '.php';

            // $file が存在して、読みこみ可能なら
            if (is_readable($file))
            {
                require $file;

                return;
            }
        }
    }
}