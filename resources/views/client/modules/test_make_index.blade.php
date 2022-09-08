<html>

<head>
    @include('admin.tests.bootstrap5')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
.h2,
h2 {
    color: #990000;
    font-size: 30px;
    margin: 0;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
}


.clock {
    position: fixed;
    bottom: 0;
    right: 0;
    width: 300px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins'
}

body {
    background: #edf2f9;
    margin-left: 50px;
}

.content {
    margin: auto;
    padding: 15px;
    max-width: 800px;
    text-align: center;
}

.dpx {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

h2 {
    font-size: 28px;
    line-height: 28px;
    margin-bottom: 15px;
}

label {
    display: block;
    line-height: 40px;
}

.option-input {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    position: relative;
    top: 13.33333px;
    right: 0;
    bottom: 0;
    left: 0;
    height: 40px;
    width: 40px;
    transition: all 0.15s ease-out 0s;
    background: #cbd1d8;
    border: none;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    margin-right: 0.5rem;
    outline: none;
    position: relative;
    z-index: 1000;
}

.option-input:hover {
    background: #9faab7;
}

.option-input:checked {
    background: #40e0d0;
}

.option-input:checked::before {
    width: 40px;
    height: 40px;
    display: flex;
    content: '\f00c';
    font-size: 25px;
    font-weight: bold;
    position: absolute;
    align-items: center;
    justify-content: center;
    font-family: 'Font Awesome 5 Free';
}

.option-input:checked::after {
    -webkit-animation: click-wave 0.65s;
    -moz-animation: click-wave 0.65s;
    animation: click-wave 0.65s;
    background: #40e0d0;
    content: '';
    display: block;
    position: relative;
    z-index: 100;
}

.option-input.radio {
    border-radius: 50%;
}

.option-input.radio::after {
    border-radius: 50%;
}

@keyframes click-wave {
    0% {
        height: 40px;
        width: 40px;
        opacity: 0.35;
        position: relative;
    }

    100% {
        height: 200px;
        width: 200px;
        margin-left: -80px;
        margin-top: -80px;
        opacity: 0;
    }
}

h6 {
    color: red;
}

#btn {
    margin-left: 50px;
}
</style>

<body>
    <?php $q=1?>
    <h2> BÀi TEST CUỐI KHÓA </h2>
    <form id="myForm" method="post" action="{{ route('save_maked',[$tests->id,$user->id]) }}">
        @csrf
        <div class="container">
            <div class='py'>

                @foreach($question as $question)
                <h5> Câu
                    <?php echo $q;?>
                    :
                    {{ $question->content}}
                </h5>
                <label>
                    <?php
$answer=$answers->where('question_id', 'like', $question->id);
    if ($question->category==2) {
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$id_user_test,1]);
        if ($users_test==null) {
            echo '<label><input name="q'.$q.'[]" type="radio" value="1" />  A) Đúng </BR></label>';
        } else {
            echo '<label><input name="q'.$q.'" type="radio" value="1" checked />  A) Đúng </BR></label>';
        }
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$id_user_test,0]);
        if ($users_test==null) {
            echo '<label><input name="q'.$q.'[]" type="radio" value="0" />  B) Sai </BR></label>';
        } else {
            echo '<label><input name="q'.$q.'" type="radio" value="0" checked/>  B) Sai </BR></label>';
        }
    }
    if ($question->category==0) {
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and question_id = ?", [$id_user_test,$question->id]);
        if ($users_test==null) {
            echo '<textarea class="form-control "
        value="" name="q'.$q.'[]" id="exampleFormControlTextarea1"placeholder="nhập câu trả lời"
        rows="3"></textarea>';
        } else {
            foreach ($users_test as $users_test) {
                echo '<textarea class="form-control "
   value="" name="q'.$q.'" id="exampleFormControlTextarea1"placeholder="nhập câu trả lời"
   rows="3">'.$users_test->answer.'</textarea>';
            }
        }
    } else {
        $k=1;
        foreach ($answer as $answer) {
            $answer1="";
            $arr_answer =[];
            $users_test = DB::select("SELECT *  FROM user_test_answers where user_test_id = ? and question_id = ?", [$id_user_test,$question->id]);
            foreach ($users_test as $users_test) {
                $answer1= $users_test->answer;
            }
            $arr_answer = explode(",", $answer1);
            if ($k==1) {
                if (in_array($answer->id, $arr_answer)==0) {
                    echo '<label><input name="q'.$q.'[]" type="checkbox" value="'.$answer->id.'"/>  A) '.$answer->content.' </BR></label>';
                } else {
                    echo '<label><input name="q'.$q.'" type="checkbox" value="'.$answer->id.'" checked/> A) '.$answer->content.' </BR></label>';
                }
            }

            if ($k==2) {
                if (in_array($answer->id, $arr_answer)==0) {
                    echo '<label><input name="q'.$q.'[]" type="checkbox" value="'.$answer->id.'" />  B) '.$answer->content.' </BR></label>';
                } else {
                    echo '<label><input name="q'.$q.'" type="checkbox" value="'.$answer->id.'"checked />  B) '.$answer->content.' </BR></label>';
                }
            }
            if ($k==3) {
                if (in_array($answer->id, $arr_answer)==0) {
                    echo '<label><input name="q'.$q.'[]" type="checkbox" value="'.$answer->id.'" />  C) '.$answer->content.' </BR></label>';
                } else {
                    echo '<label><input name="q'.$q.'" type="checkbox" value="'.$answer->id.'"checked />  C) '.$answer->content.' </BR></label>';
                }
            }
            if ($k==4) {
                if (in_array($answer->id, $arr_answer)==0) {
                    echo '<label><input name="q'.$q.'[]" type="checkbox" value="'.$answer->id.'" />  D) '.$answer->content.' </BR></label>';
                } else {
                    echo '<label><input name="q'.$q.'" type="checkbox" value="'.$answer->id.'" checked/>  D) '.$answer->content.' </BR></label>';
                }
            }
            $k++;
        }
    }

    ?><?php $q++;?>
                    <hr>
                </label>
                @endforeach
                <button type="submit" class="btn btn-primary">Nộp bài</button>
                <a id="btn" class="btn btn-primary" href="{{route('home')}}">
                    Quay lại
                </a>
    </form></BR></BR>


    <?php
if ($u->status==1 && $u->score!=null) {
    echo'
        <h6>Bạn đã được số điểm là: '.$u->score.'</h6>';
} elseif ($u->status==1 && $u->score==null) {
    echo'
        <h6>Vui lòng đợi giáo viên chấm.</h6>';
}
    ?>

    @php
    if($u->status == 0)
    echo
    '<div class="clock">
        <p>Thời gian làm bài: <span id="h"> Giờ</span> :
            <span id="m">Phút</span> :
            <span id="s">Giây</span>
        </p>
    </div>';
    @endphp

    <script language="javascript">
    window.addEventListener('load', start);
    var h = null; // Giờ
    var m = null; // Phút
    var s = null; // Giây

    var timeout = null; // Timeout

    function start() {
        /*BƯỚC 1: LẤY GIÁ TRỊ BAN ĐẦU*/
        if (h === null) {

            <?php
                $hourse=0;
    $minute=$tests->time;
    if ($minute>=60) {
        $hourse = floor($minute/60);
        $minute = $minute%60;
    }
    ?>
            h = <?php  echo $hourse;?>;
            m = <?php echo $minute?>;
            s = 0;
        }

        /*BƯỚC 1: CHUYỂN ĐỔI DỮ LIỆU*/
        // Nếu số giây = -1 tức là đã chạy ngược hết số giây, lúc này:
        //  - giảm số phút xuống 1 đơn vị
        //  - thiết lập số giây lại 59
        if (s === -1) {
            m -= 1;
            s = 59;
        }

        // Nếu số phút = -1 tức là đã chạy ngược hết số phút, lúc này:
        //  - giảm số giờ xuống 1 đơn vị
        //  - thiết lập số phút lại 59
        if (m === -1) {
            h -= 1;
            m = 59;
        }

        // Nếu số giờ = -1 tức là đã hết giờ, lúc này:
        //  - Dừng chương trình
        if (h == -1) {
            clearTimeout(timeout);
            $(document).ready(function() {
                $("#myForm :input").prop("disabled", true);
                location.replace("{{ route('save_maked_get',[$tests->id,$user->id]) }}");
            });

            return false;
        }

        /*BƯỚC 1: HIỂN THỊ ĐỒNG HỒ*/
        document.getElementById('h').innerText = h.toString();
        document.getElementById('m').innerText = m.toString();
        document.getElementById('s').innerText = s.toString();

        /*BƯỚC 1: GIẢM PHÚT XUỐNG 1 GIÂY VÀ GỌI LẠI SAU 1 GIÂY */
        timeout = setTimeout(function() {
            s--;
            start();
        }, 1000);

        function stop() {
            clearTimeout(timeout);
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?php
    if ($u->status==1) {
        echo '<script>

      $(document).ready(function(){
        $("#myForm :input").prop("disabled", true);
        $("#btn").prop("disabled", null);
    });
</script>';
    } else {
        echo '<script>

        $(document).ready(function(){
          $("#btn").prop("disabled", true);
      });
      $("#btn")
        .addClass("disabled")
        .prop("data-href", $(this).prop("href"))
        .prop("href","#")
  </script>';
    }
    ?>

</body>

</html>
