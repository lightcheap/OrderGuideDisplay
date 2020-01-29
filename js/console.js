$(function(){
    // 操作画面の処理をいったんここにだーっと書く

    // 操作画面の操作クラス
    class NumberUPdate {
        constructor(){
            this.selectnumber = "";
            this.selectid = "";

        }

        // 待ち番号の更新
        reloadWait(){
            //console.log('待ち番号更新');
            var statusid = 1;
            $.ajax({
                type: 'POST',
                data: {
                    'number': statusid
                },
                url:'/yakiniku2/process/console/Reload.php',
                success: function(data){
                    // 前回分を消す
                    $('#w_n_d_area').children().remove();
                    // ゲットした番号を待ちの所にだす
                    $.each(data, function(key, value){
                        $('#w_n_d_area').append(
                            '<div class="n_c">'
                            +'<span>'+ (key+1) +'</span>'
                            +'<p class="w_n_cont" id="wnd'+ (key+1) +'">'
                            + value.call_number +'</p>'
                            +'</div>'
                        );
                    });
                },
                error: function(){
                    console.log('待ち時間の更新失敗');
                }
            });
        }


        // 呼び出し番号の更新
        reloadCall(){
            //console.log('呼び出し番号更新');
            var statusid = 2;
            $.ajax({
                type: 'POST',
                data: {
                    'number': statusid
                },
                url:'/yakiniku2/process/console/Reload.php',
                success: function(data){
                    // 前回の分を消す
                    $('#c_n_d_area').children().remove();
                    // 呼び出し番号を呼び出し部分に表示
                    $.each(data, function(key, value){
                        $('#c_n_d_area').append(
                            '<div class="n_c">'
                            +'<span>'+ (key+1) +'</span>'
                            +'<p class="n_c_cont" id="cnd'+ (key+1) +'">'
                            + value.call_number +'</p>'
                            +'</div>'
                        );
                    });
                },
                error: function(){
                    console.log('呼び出し時間の更新失敗');
                }
            });
        }


        // 待ちモーダルの表示
        waitModalDisplay(){
            // 呼び出しますか？を表示して完了を消す
            $('#to_call_contents').css('display','block');
            $('#to_complete_contents').css('display','none');

            // 完了ボタンを消して呼び出しボタンを表示
            $('#comp').css('display','none');
            $('#call').css('display','block');

            // モーダル表示
            $('#modal').css('display','block');
        }


        // 呼び出しモーダルの表示
        callModalDisplay(){
            // 完了しますか？を表示して呼び出しますかを消す
            $('#to_call_contents').css('display','none');
            $('#to_complete_contents').css('display','block');

            // 呼び出しボタンを消して完了ボタンを表示
            $('#call').css('display','none');
            $('#comp').css('display','block');

            // モーダル表示
            $('#modal').css('display','block');
        }

        // リセット用モーダルの表示
        resetModalDisplay(){
            $('#verify_modal').css('display','block');
        }

        noticeDisplay(){
            $('#notice_modal').css('display','block');
        }

    }

    // 待ち/呼び出し番号の左上番号を押したい
    function getType(e){
        // 入力されたキーコードを受け取る
        let input_key_code = e.key;
    }

        // インスタンス
    operation_screen = new NumberUPdate();

    $(document).on('keypress', function(e){
        // 数字のキーが押されたら処理するよ
        console.log(e.key);//これでおしたキーのまんまかえってくる

    });

    /**
    * 画面がリロードされた時
    * 現在の待ち番号/呼び出し番号の情報を取得後表示する
    */
    $(document).ready(function(){
        operation_screen.reloadWait();
        operation_screen.reloadCall();
    })

    // 表示を定期的に更新
    setInterval(() => {
        operation_screen.reloadWait();
        operation_screen.reloadCall();
    }, 1000);


    // 番号生成ボタンが押されたら現在の待ち番号に数字を追加する
    $(document).on('click', '#create_number',function(){
        console.log('番号生成ボタンおし');

        $.ajax({
            type: 'POST',
            data: {},
            url:'/yakiniku2/process/console/getTodayCountNumber.php',
            success: function(data){
                //console.log(data);
                // 前回分を消す
                $('#w_n_d_area').children().remove();
                // ゲットした番号を待ちの所にだす
                $.each(data, function(key, value){
                    $('#w_n_d_area').append(
                        '<div class="n_c">'
                        +'<span>'+ (key+1) +'</span>'
                        +'<p class="w_n_cont" id="wnd'+ (key+1) +'">'
                        + value.call_number +'</p>'
                        +'</div>'
                    );
                });
            },
            error: function(){
                console.log('待ち時間の取得失敗');
            }
        });
    })

    
    // 待ち番号->呼び出し番号を移動する処理
    $(document).on('click', '.w_n_cont', function(){
        console.log('待ち数字部分おした');
        // 選んだ番号を入れる変数
        let selectnumber;
        let selectid;

        // 待ち番号を取得
        selectnumber = $(this).text();
        // 待ち番号のID
        selectid = $(this).attr('id');

        console.log('選択した番号',selectnumber);
        console.log('選択したID',selectid);

        // モーダルの一番上に表示する番号ゲット
        $('#target_number').text(selectnumber);

        operation_screen.waitModalDisplay();

        // 呼び出しボタンおした処理
        $(document).on('click', '#call', function(){
            console.log('呼び出しボタンおした');

            // 呼び出しのステータスID
            var search_status_id = 1;
            var updata_status_id = 2;
            var updata_column_name = "waiting_at";

            // 対象の番号のステータスIDの更新
            // 呼び出し表示の更新
            $.ajax({
                type: 'POST',
                data: {
                    'selectnumber': selectnumber,
                    'search_status_id': search_status_id,
                    'updata_status_id': updata_status_id,
                    'updata_column_name': updata_column_name
                },
                url:'/yakiniku2/process/console/CallNumberUpdate.php',
                success: function(data){
                    //console.log(data);

                    // 呼び出し番号の前回分を消す
                    $('#c_n_d_area').children().remove();

                    // 呼び出し番号を呼び出し部分に表示
                    $.each(data, function(key, value){
                        $('#c_n_d_area').append(
                            '<div class="n_c">'
                            +'<span>'+ (key+1) +'</span>'
                            +'<p class="n_c_cont" id="cnd'+ (key+1) +'">'
                            + value.call_number +'</p>'
                            +'</div>'
                        );
                    });
                    //モーダルが邪魔
                    $('#modal').css('display','none');

                    // 待ち部分の更新
                    operation_screen.reloadWait();
                },
                error: function(){
                    console.log('error!');
                }
            });

        });
    });


    // 呼び出し番号をクリックしたらその後の処理
    // 呼び出し用としてのモーダルを開いて完了か戻るか選択
    $(document).on('click', '.n_c_cont', function(){
        //console.log('呼び出し数字部分おした');
        // 呼び出し番号を取得
        var selectnumber = $(this).text();
        //console.log(selectnumber);

        // モーダルの一番上に番号表示
        $('#target_number').text(selectnumber);

        operation_screen.callModalDisplay();

        // 完了ボタンを押した処理
        $(document).on('click', '#comp', function(){
            // クリックして番号をAjaxで送信、論理削除する
            console.log('完了ボタンおした');
            console.log('完了させる番号：',selectnumber);

            // 完了（削除）のステータスID
            var updata_status_id = 3;
            var search_status_id = 2;
            var updata_column_name = "delete_at";

            // 番号をajaxでphp側に送信
            $.ajax({
                type: 'POST',
                data: {
                    'selectnumber': selectnumber,
                    'search_status_id': search_status_id,
                    'updata_status_id': updata_status_id,
                    'updata_column_name': updata_column_name
                },
                url:'/yakiniku2/process/console/CallNumberUpdate.php',
                success: function(data){
                    console.log(data);
                    // 呼び出し番号の前回分を消す
                    $('#c_n_d_area').children().remove();

                    // 呼び出し番号を呼び出し部分に表示
                    $.each(data, function(key, value){
                        $('#c_n_d_area').append(
                            '<div class="n_c">'
                            +'<span>'+ (key+1) +'</span>'
                            +'<p class="n_c_cont" id="cnd'+ (key+1) +'">'
                            + value.call_number +'</p>'
                            +'</div>'
                        );
                    });

                    //モーダルを消す
                    $('#modal').css('display','none');
                },
                error: function(){
                    console.log('error!');
                }
            });
        });

    });


    // モーダルの戻るボタンおした処理
    $(document).on('click', '#modal_back', function(){
        // モーダル消す
        $('#modal').css('display','none');
    });


    // 閉店用リセットボタンをおしたら
    $(document).on('click', '#number_reset', function(){
        // リセットモーダルの表示
        operation_screen.resetModalDisplay();
    });

    $(document).on('click', '#verify_back', function(){
        // リセットモーダルの非表示
        $('#verify_modal').css('display','none');
    });

    // リセット用モーダルのリセットボタンを押したとき
    $(document).on('click', '#all_number_reset', function(){
        console.log('リセットボタンおした');
        // 待ち、呼び出し分を完了ステータスにする
        var updata_status_id = 3;

        $.ajax({
            type: 'POST',
            data: {
                'updata_status_id': updata_status_id
            },
            url:'/yakiniku2/process/console/CallNumberAllReset.php',
            success: function(data){
                console.log(data);

                $('#verify_modal').css('display','none');

                // 待ちと呼び出しの表示更新
                operation_screen.reloadWait();
                operation_screen.reloadCall();
            },
            error: function(){
                console.log('All Status Number Update Error');
            }
        });
    });


});
