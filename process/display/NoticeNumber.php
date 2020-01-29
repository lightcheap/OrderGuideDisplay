<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php')?>
<?php
/**
 * ステータスが２で最新日付のデータを探す
 */
$request = new Request;
$dbmanager = new DbManager;

if( $request->isPost())
{
    $search_status_id = $request->getpost('number');

    try
    {
        $dbhandle = $dbmanager->connect();

        $sql = 'SELECT call_number
                FROM t_call_number
                WHERE status_id=:status_id
                ORDER BY waiting_at DESC
                LIMIT 1';

        $stmt = $dbhandle->prepare($sql);
        $stmt->bindValue(':status_id', $search_status_id, PDO::PARAM_STR);
        $stmt->execute();
        $sql_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbhandle = null;
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
echo(json_encode($sql_result));