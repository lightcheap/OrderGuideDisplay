<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php')?>
<?php
/**
 * 待ち、呼び出し番号のステータスを全て完了にする
 */
$request = new Request;
$dbmanager = new DbManager;

if( $request->isPost())
{
    // Ajaxから来たデータを代入する
    $updata_status_id = $request->getpost('updata_status_id');

    // 現在時間を取得する
    $update_time = date('Y-m-d H-i-s');

    try
    {
        $dbhandle = $dbmanager->connect();

        $sql = 'UPDATE t_call_number
                SET status_id=:status_id,
                    reset_at=:reset_at
                WHERE status_id !=:where_status_id';

        $stmt = $dbhandle->prepare($sql);

        $stmt->bindValue(':status_id', $updata_status_id, PDO::PARAM_STR);
        $stmt->bindValue(':reset_at', $update_time, PDO::PARAM_STR);
        $stmt->bindValue(':where_status_id', $updata_status_id, PDO::PARAM_STR);

        $stmt->execute();

        $dbhandle = null;
        $comment = "ステータス完了";

    }
    catch(PDOException $e)
    {

    }
}
else
{
    // POST処理じゃないとき
}
header('Content-type: application/json');
// htmlへ渡す配列 $attendance_data をjsonに変換する
echo(json_encode($comment));