$(function(){
/**
 * 表示板用のjsをまとめる
 */

    // 表示板のクラス
    class Display {
        //コンストラクタ
        constructor(){
            this.array_wait_number = new Array;
            this.array_call_number = new Array;

            this.array_diff_waitnumber = new Array;
            this.array_diff_callnumber = new Array;
        }

        //
        setWaitNumber(array){
            this.array_wait_number = array;
        }

        getWaitNumber(){
            return this.array_wait_number;
        }

        setCallNumber(array){
            this.array_call_number = array;
        }

        getCallNumber(){
            return this.array_call_number;
        }

        setDWaitNum(array){
            this.array_diff_waitnumber = array;
        }

        getDWaitNum(){
            return this.array_diff_waitnumber;
        }

        setDCallNum(array){
            this.array_diff_callnumber = array;
        }

        getDCallNum(){
            return this.array_diff_callnumber;
        }


        //待ち番号を呼び出し、大きく表示 d
        orderHasCome(ordernumber){
            // 番号セット
            $('#display_number').text(ordernumber);

            $('#notice_modal').css('display','block');
            setTimeout(() => {
                $('#notice_modal').css('display','none');
            }, 3500);

        }
    }

    // 新呼び出し番号と旧呼び出し番号の差を求める
    function getDiff(array1, array2){
        let sabun = array1.concat(array2);
        return sabun.filter((v, i) => {
            return !(array1.indexOf(v) !== -1 && array2.indexOf(v) !== -1);
        });
    }

    display = new Display();

    // 番号表示を定期的に更新
    setInterval(() => {
        //待ち
        let before_wn = display.getWaitNumber();
        let now_wn = new Array;
        let diff_wn = new Array;
        var wait_status = 1;
        $.ajax({
            type: 'POST',
            data: {
                'number': wait_status
            },
            url: '/yakiniku2/process/display/Reload.php',
            success: function(data){
                //console.log(data);
                // 待ち番号の前回分を消す
                $('#wait_number_display').children().remove();

                $.each(data, function(key, value){
                    $('#wait_number_display').append(
                        '<div class="wait_number_content">'
                        + value.call_number + '</div>'
                    );
                    //番号を配列に取得
                    now_wn.push(value.call_number);
                });
                //番号と前回との差分を持っておく
                display.setWaitNumber(now_wn);
                diff_wn = getDiff(now_wn, before_wn);
                display.setDWaitNum(diff_wn);
                //console.log('まち差', diff_wn);
            },
            error: function(){}
        });


        // 呼び出しの更新  d
        let before_sn = display.getCallNumber();
        let now_sn = new Array;
        let diff_sn = new Array;
        var call_status = 2;
        $.ajax({
            type: 'POST',
            data: {
                'number': call_status
            },
            url: '/yakiniku2/process/display/Reload.php',
            success: function(data){
                // 呼び出しの前回分を消す
                $('#call_number_display').children().remove();
                // 呼び出し分を表示する
                $.each(data, function(key, value){
                    $('#call_number_display').append(
                        '<div class="call_number_content">'+
                        + value.call_number + '</div>'
                    );
                    // 番号を配列に取得
                    now_sn.push(value.call_number);

                });
                display.setCallNumber(now_sn);
                diff_sn = getDiff(now_sn, before_sn);
                display.setDCallNum(diff_sn);

            },
            error: function(){}
        });

        // 差分を呼び出し
        let dwn = display.getDWaitNum();
        let dcn = display.getDCallNum();

        // 待ちで抜けた分＝呼び出しに足した分　で呼び出し
        if(dwn.length != 0 && dwn[0] == dcn[0]){
            display.orderHasCome(dwn);
        }

    }, 1000);
});
