<html>

<head>
    @include('admin.tests.bootstrap5')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
.h1,
h1 {
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

h1 {
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
    
    <h1> Bài test</h1>
    <form method="post" action="{{ route('send.test', $user_test) }}" id="do_test">
        @csrf

        <div class="card-body">
            <div class="form-group">

                @foreach ($questions as $question)
                <h3 for="question" style="margin-bottom: 1.2rem">
                <label> {{ $loop->iteration }}. {{ $question->content }}</label>
                </h3>
                @if($question->category == 2)
                <label><input name="true[{{ $question->id }}]" type="radio" value="1" checked /> A) Đúng </BR></label>
                <label><input name="true[{{ $question->id }}]" type="radio" value="0" /> B) Sai </BR></label>
                @endif
                @if ($question->category == 0)

                <textarea class="form-control " value="" name="essay[{{ $question->id }}]" id="exampleFormControlTextarea1" placeholder="nhập câu trả lời" rows="3"></textarea>
                @else
                @foreach ($question->answers as $option)
                <label> <input type="checkbox" name="answers[]" value="{{ $option->id }}" /> {{ $option->content }}</label>

                @endforeach

                @endif
                @endforeach

            </div>


        </div>


        <!-- /.card-body -->
        <br>

        <button type="submit" class="btn btn-primary" onclick="stop()" id="checkBtn">Nộp bài</button></BR>      
    </form>

    @php

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
                $hourse = 0;
                $minute = $test->time;
                if ($minute >= 60) {
                    $hourse = floor($minute / 60);
                    $minute = $minute % 60;
                }
                ?>
                h = <?php echo $hourse; ?>;
                m = <?php echo $minute ?>;
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
        
                    $('#do_test').submit();
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

    if ($score != null) {

        echo '<script>
    
      $(document).ready(function(){
        $("#do_test :input").prop("disabled", true);
    });
</script>';
    }
    ?>
    
    <script type="text/javascript">


</script>
</body>

</html>