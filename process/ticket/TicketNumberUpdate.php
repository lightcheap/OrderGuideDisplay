<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php')?>
<?php
/**
 * 各自受け取った番号の状況の更新
 * 番号とIDで検索してステータスIdを取得する
 */
$request = new Request;
$dbmanager = new DbManager;

$number_id = session_id();

if($request->isPost())
{
    //Ajaxから来たデータ
    $number = $request->getpost('number');
    try
    {
        $dbhandle = $dbmanager->connect();
        $sql = 'SELECT status_id
                FROM t_call_number
                WHERE call_number=:call_number
                AND number_id=:number_id';

        $stmt = $dbhandle->prepare($sql);
        $stmt->bindValue(':call_number', $number, PDO::PARAM_STR);
        $stmt->bindValue(':number_id', $number_id, PDO::PARAM_STR);

        $stmt->execute();
        $sql_result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        // 接続失敗
    }
}
else
{
    // POST処理じゃないとき
}
header('Content-type: application/json');
// htmlへ渡す配列 $attendance_data をjsonに変換する
echo(json_encode($sql_result));