<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Upper.php');?>
<main>
    <div class="display_container">
        <div class="wait_display"><!--待ちエリア-->
            <div class="display_title">
                <p>待ち表示部分</p>
            </div>
            <div class="wait_number_display" id="wait_number_display"><!--番号表示エリア-->
            </div>
        </div>
        <div class="call_display"><!--呼び出しエリア-->
            <div class="display_title">
                <p>呼び出し表示部分</p>
            </div>
            <div class="call_number_display" id="call_number_display"><!--番号表示エリア-->
            </div>
        </div>
        <!--番号リセット用のモーダル-->
        <div class="notice_modal" id="notice_modal"><!--モーダル以外の背景-->
            <div class="modalcontent notice" id="modalcontent"><!--モーダルウィンドう-->
                <div class="modalbody noticeline" id="modalbody">
                    <h2 class="notice_contents" id="notice_contents">お待たせしました</h2>
                    <div class="display_number" id="display_number">
                    </div>
                </div>
            </div>
        </div>
        <!--番号リセットモーダルここまで-->
    </div>
</main>
<script src="/yakiniku2/js/display.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Lower.php');?>
