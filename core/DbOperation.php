<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/core/DbManager.php');?>
<?php
// DB操作のクラスとか作ってみたかったり
class DbOperation
{
    public function __construct()
    {
        
    }

    public function Reload($status_id)
    {
        $dbmanager = new DbManager;
        // データベースにアクセスして現在のデータを取得する
        try
        {
            $dbhandle = $dbmanager->connect();
            $sql = 'SELECT call_number, status_id, created_at, waiting_at
                    FROM t_call_number
                    WHERE status_id=:status_id ORDER BY created_at ASC';
            
            $stmt = $dbhandle->prepare($sql);

            $stmt->bindValue(':status_id', $status_id, PDO::PARAM_STR);

            $stmt->execute();
            $get_callnumber = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dbhandle = null;

            return $get_callnumber;
        }
        catch(PDOException $e)
        {
            // 接続失敗

        }
    }

}
