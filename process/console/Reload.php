<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php
/**
 * コンソールのリロード処理
 */

$request = new Request;
$dbmanager = new DbManager;

if( $request->isPost() )
{
    $set_id = $request->getpost('number');
    try
    {
        $dbhandle = $dbmanager->connect();
        $sql = 'SELECT call_number, status_id, created_at, waiting_at
                FROM t_call_number
                WHERE status_id=:status_id ORDER BY created_at ASC';
        
        $stmt = $dbhandle->prepare($sql);

        $stmt->bindValue(':status_id', $set_id, PDO::PARAM_STR);

        $stmt->execute();
        $get_callnumber = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbhandle = null;
    }
    catch(PDOException $e)
    {
        // はい接続失敗～

    }

}
else
{

}
header('Content-type: application/json');
// htmlへ渡す配列 $attendance_data をjsonに変換する
echo(json_encode($get_callnumber));