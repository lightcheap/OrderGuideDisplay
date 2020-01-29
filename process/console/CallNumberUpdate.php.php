<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php')?>
<?php
/**
 * 呼び出し番号のステータスをIDで更新する処理
 */
$request = new Request;
$dbmanager = new DbManager;

if( $request->isPost())
{
    // Ajaxから来たデータを代入する変数
    $selectnumber = $request->getpost('selectnumber');
    $search_status_id = $request->getpost('search_status_id');
    $updata_status_id = $request->getpost('updata_status_id');
    $updata_column_name = $request->getpost('updata_column_name');
    // 現在時間を取得する
    $update_time = date('Y-m-d H-i-s');

    try
    {
        // 対象番号のstatus_idを変えて更新する
        $dbhandle = $dbmanager->connect();

        $sql = 'UPDATE t_call_number
                SET status_id=:status_id,
                    '.$updata_column_name.'=:updata_column_name
                WHERE call_number=:call_number AND status_id=:search_status_id';

        $stmt = $dbhandle->prepare($sql);

        $stmt->bindValue(':status_id', $updata_status_id, PDO::PARAM_STR);
        $stmt->bindValue(':call_number', $selectnumber, PDO::PARAM_STR);
        $stmt->bindValue(':search_status_id', $search_status_id, PDO::PARAM_STR);
        $stmt->bindValue(':updata_column_name', $update_time, PDO::PARAM_STR);

        $stmt->execute();

        // 呼び出しステータスを持つ番号を取得する
        $sql2 = 'SELECT call_number, status_id
                FROM t_call_number
                WHERE status_id=:status_id ORDER BY created_at ASC';

        $stmt = $dbhandle->prepare($sql2);

        $stmt->bindValue(':status_id', 2, PDO::PARAM_STR);
        $stmt->execute();

        $get_incallnumber = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
echo(json_encode($get_incallnumber));