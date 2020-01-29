<?php require($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/bootstrap.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Upper.php');?>
<main>
    <!--各お客さんの番号画面-->
    <div class="container">
        <div class="number_display" id="number_display"></div>
        <div class="status_display" id="status_display"></div>
        <div class="">
            <p class="p_button call" id="number_ticketing">待つ</p>
        </div>
    </div>
</main>
<script src="/yakiniku2/js/numbered_ticket.js?23"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/yakiniku2/temp/common/Lower.php');?>