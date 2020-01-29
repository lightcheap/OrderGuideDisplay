$(function(){
    // 発券関係

    class NumberTicket {
        constructor(){
            this.ticket_number = 0;
        }

        setNumber(number){
            this.ticket_number = number;
        }

        getNumber(){
            return this.ticket_number;
        }
    }

    number_ticket = new NumberTicket();

    //読みこまれたら待ち番号があるかどうか調べる。
    //ある->番号表示　/　ない->なにもしない
    $(function(){
        $.ajax({
            type: 'POST',
            data: {},
            url: '/yakiniku2/process/ticket/SearchNumberTicket.php',
            success: function(data){
                console.log(data);
                if(data != false){
                    console.log('あるよ');
                    // ボタンを消す
                    $('#number_ticketing').css('display','none');
                    $('#number_display').text(data.call_number);
                    // クラスメンバにセットする
                    number_ticket.setNumber(data.call_number);
                }else{
                    console.log('ないよ');
                }
            },
            error : function(){
                console.log('エラー');
            }
        });
    });


    // ボタンを押したら番号発券
    $(document).on('click', '#number_ticketing', function(){
        console.log('待ちボタンおし');
        // ボタンを消す
        $('#number_ticketing').css('display','none');

        $.ajax({
            type: 'POST',
            data: {},
            url: '/yakiniku2/process/ticket/NumberedTicketing.php',
            success: function(data){
                console.log(typeof(data), data);
                $('#number_display').text(data);
                // クラスメンバにセットする
                number_ticket.setNumber(data);
            },
            error : function(){}
        });
    })

    // 定期的にDB情報をとりにいって
    // ステータスIDを取得する
    setInterval(() => {
        let ticketnumber = number_ticket.getNumber();
        console.log('毎', ticketnumber);

        $.ajax({
            type: 'POST',
            data: {
                'number':ticketnumber
            },
            url:'/yakiniku2/process/ticket/TicketNumberUpdate.php',
            success: function(data){
                console.log(data.status_id);
                if(data.status_id == 1){
                    console.log('待ち中');
                    $('#status_display').text("もうしばらくお待ちください。");
                }else if(data.status_id == 2){
                    console.log('呼び出し中');
                    $('#status_display').text("お待たせ致しました。");
                }else if(data.status_id == 3){
                    console.log('完了');
                    $('#status_display').text("本日はありがとうございます。");
                }else{
                    console.log('想定外の値');
                }
            },
            error: function(){}

        });
    }, 3000);
});