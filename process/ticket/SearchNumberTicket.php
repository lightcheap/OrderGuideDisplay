<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php
/**
 * 同じIDの待ち番号がないか調べる処理
 * ある-> 番号返す ない->スルー
 */
$request = new Request;
$dbmanager = new DbManager;

if($request->isPost())
{
    try
    {
        $dbhandle = $dbmanager->connect();
        //（とりあえず）セッションIDが同じ番号があるかDB内を検索する
        $sql = 'SELECT call_number
                FROM t_call_number
                WHERE number_id=:number_id AND status_id=:status_id ORDER BY created_at DESC
                LIMIT 1';
        
        $stmt = $dbhandle->prepare($sql);
        $stmt->bindValue(':number_id', session_id(), PDO::PARAM_STR);
        $stmt->bindValue(':status_id', 1, PDO::PARAM_STR);

        $stmt->execute();
        $sql_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbhandle = null;

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