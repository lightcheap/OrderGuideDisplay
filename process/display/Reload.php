<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php
/**
 * 表示板のリロード処理
 */

$request = new Request;
$dboperation = new DbOperation;

if( $request->isPost() )
{
    $status_id = $request->getpost('number');
    $get_data = $dboperation->Reload($status_id);
}
else
{

}
header('Content-type: application/json');
// htmlへ渡す配列 $attendance_data をjsonに変換する
echo(json_encode($get_data));