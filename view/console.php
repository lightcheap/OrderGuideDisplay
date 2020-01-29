<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Upper.php');?>
<header class="console_top_header">
    <div class="console_top_title">
        <h1>操作画面</h1>
    </div>
    <div class="console_top_menu">
        <ul>
            <li><button id="create_number">番号生成</button></li>
            <li><button id="number_reset">閉店リセット</button></li>
        </ul>
    </div>
</header>
<main>
<div class="console_container">
    <div class="waiting_number_contents">
        <div class="waiting_number_title">
            <h2>現在の待ち番号：</h2>
        </div>
        <div class="waiting_number_display_area flex" id="w_n_d_area">
        </div>
    </div>
    <div class="calling_number_contents">
        <div class="calling_number_title">
            <h2>呼び出し番号：</h2>
        </div>
        <div class="calling_number_display_area flex" id="c_n_d_area">
        </div>
    </div>
    <!--モーダルウィンドウ（呼び出し/完了）-->
    <div class="modal" id="modal"><!--モーダル以外の背景-->
        <div class="modalcontent callandcomp" id="modalcontent"><!--モーダルウィンドう-->
            <div class="modalbody" id="modalbody">
                <div class="number_contents flex">
                    <p class="no">No.</p>
                    <h2 class="target_number" id="target_number"></h2>
                </div>
                <h2 class="to_call_contents" id="to_call_contents">呼び出しますか？</h2>
                <h2 class="to_complete_contents" id="to_complete_contents">完了しますか？</h2>
                <div>
                    <p class="p_button call" id="call">呼出</p>
                    <p class="p_button comp" id="comp">完了</p>
                    <p class="p_button back" id="modal_back">戻る</p>
                </div>
            </div>
        </div>
    </div>
    <!--モーダルウィンドウここまで-->
    <!--番号リセット用のモーダル-->
    <div class="verify_modal" id="verify_modal"><!--モーダル以外の背景-->
        <div class="modalcontent verify" id="modalcontent"><!--モーダルウィンドう-->
            <div class="modalbody" id="modalbody">
                <h2 class="to_call_contents" id="to_call_contents">待ち/呼び出し番号を全部リセットします。</h2>
                <div>
                    <p class="p_button all_number_reset" id="all_number_reset">リセット</p>
                    <p class="p_button back" id="verify_back">戻る</p>
                </div>
            </div>
        </div>
    </div>
    <!--番号リセットモーダルここまで-->
</div>
</main>
<script src="/yakiniku2/js/console.js?67"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Lower.php');?>