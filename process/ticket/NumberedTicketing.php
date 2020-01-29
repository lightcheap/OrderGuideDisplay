<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php')?>
<?php
/**
 * 待ち番号を呼び出す
 * 今日の発行番号数をSQLから取得してそれの +1した数をゲットしたい
 * numbered_ticket.phpからのAjaxからくる
 */
$request = new Request;
$dbmanager = new DbManager;

// SQL検索用の今日を取得
$today_start = date('Y-m-d') . " 00:00:00";
$today_end = date('Y-m-d') . " 23:59:59";
//ユーザー識別をとりあえずsession_idにする
$number_id = session_id();
setcookie('number_id', $number_id, time()+60*60*2);
if($request->isPost())
{
    try
    {
        $dbhandle = $dbmanager->connect();
        // 現在の日付でいくつあるかカウントする--------------------------------
        $sql = 'SELECT
                COUNT((created_at BETWEEN :start_time AND :end_time) or NULL)
                FROM t_call_number';

        $stmt = $dbhandle->prepare($sql);
        $stmt->bindValue(':start_time', $today_start, PDO::PARAM_STR);
        $stmt->bindValue(':end_time', $today_end, PDO::PARAM_STR);

        $stmt->execute();
        $sql_result = $stmt->fetch(PDO::FETCH_ASSOC);
        //------------------------------------------------------------------
        // +1する
        $set_callnumber = $sql_result['COUNT((created_at BETWEEN ? AND ?) or NULL)'] + 1;

        // この数値を呼び出し番号として保存-----------------------------------
        $sql2 = 'INSERT INTO t_call_number(
                            call_number, status_id, number_id)
                VALUE(:call_number, :status_id, :number_id)';

        $stmt = $dbhandle->prepare($sql2);
        $stmt->bindValue(':call_number', $set_callnumber, PDO::PARAM_STR);
        $stmt->bindValue(':status_id', 1, PDO::PARAM_STR);//とりあえず
        $stmt->bindValue(':number_id', $number_id, PDO::PARAM_STR);

        $stmt->execute();

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
echo(json_encode($set_callnumber));