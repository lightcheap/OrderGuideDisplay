<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Upper.php');?>
<main>
    <div class="container">
        <div class="top_title_contents">
            <p class="top_title">やきにく番号表示板</p>
        </div>
        <div class="top_menu_contents">
            <div>
                <a href="/yakiniku2/view/display.php" target="_blank" rel="noopener noreferrer">
                    <p class="p_button top_menu">番号表示板</p>
                </a>
            </div>
            <div>
                <a href="/yakiniku2/view/console.php" target="_blank" rel="noopener noreferrer">
                    <p class="p_button top_menu">操作板</p>
                </a>
            </div>
            <div>
                <a href="/yakiniku2/view/qr.php" target="_blank" rel="noopener noreferrer">
                    <p class="p_button top_menu">QRコード</p>
                </a>
            </div>
            <div>
                <a href="/yakiniku2/view/numbered_ticket.php" target="_blank" rel="noopener noreferrer">
                    <p class="p_button top_menu">番号札画面（後で消す）</p>
                </a>
            </div>
        </div>
    </div>
</main>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Lower.php');?>
