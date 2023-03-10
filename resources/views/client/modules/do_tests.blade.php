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

    <h1>B??i test</h1>
    <form method="post" action="{{ route('send.test', $id) }}" id="do_test" onSubmit="return confirm('B???n c?? ch???c ch???n mu???n n???p b??i?') ">
        @csrf
        <div class="card-body">
            <div class="form-group">
                @foreach ($questions as $question)
                    <h3 for="question" style="margin-bottom: 1.2rem">
                        <label>
                            {{ $loop->iteration . '. ' . $question->content }}
                        </label>
                    </h3>
                    @if ($question->category == 2)
                        <label>
                            <input name="tfQuest[{{ $question->id }}]" type="radio" value="1" /> A) ????ng
                            </BR>
                        </label>
                        <label>
                            <input name="tfQuest[{{ $question->id }}]" type="radio" value="0" /> B) Sai
                            </BR>
                        </label>
                    @elseif ($question->category == 0)
                        <textarea class="form-control " value="" name="essayQuest[{{ $question->id }}]" id="exampleFormControlTextarea1"
                            placeholder="nh???p c??u tr??? l???i" rows="3"></textarea>
                    @else
                        @foreach ($question->answers as $option)
                            <label>
                                <input type="checkbox" name="multiQuest[{{ $question->id }}][]" value="{{ $option->id }}" />
                                {{ $option->content }}
                            </label>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
        <!-- /.card-body -->
        <br>
        <button type="submit" class="btn btn-primary" onclick="stop()" id="checkBtn">
            N???p b??i
        </button>
        <br>
    </form>
    <div class="clock">
        <p>Th???i gian l??m b??i: 
            <span id="h"></span> :
            <span id="m"></span> :
            <span id="s"></span>
        </p>
    </div>

    <script language="javascript">
        window.addEventListener('load', start);
        var h = null; // Gi???
        var m = null; // Ph??t
        var s = null; // Gi??y
        var timeout = null; // Timeout

        function start() {
            /*B?????C 1: L???Y GI?? TR??? BAN ?????U*/
            if (h === null) {
                @php
                    $passedSeconds = Carbon\Carbon::now()->diffInSeconds($startedTime);
                    
                    $hours = 0;
                    $minutes = 0;
                    $seconds = abs($passedSeconds - $test->time * 60);
                    
                    if ($seconds >= 60) {
                        $minutes = floor($seconds / 60);
                        $seconds = $seconds % 60;
                    }
                    
                    if ($minutes >= 60) {
                        $hours = floor($minutes / 60);
                        $minutes = $minutes % 60;
                    }
                @endphp
                h = {{ $hours }}
                m = {{ $minutes }}
                s = {{ $seconds }}
                if ({{ $passedSeconds }} >= {{ $test->time * 60 }}) {
                    stop();
                }
            }

            /*B?????C 1: CHUY???N ?????I D??? LI???U*/
            // N???u s??? gi??y = -1 t???c l?? ???? ch???y ng?????c h???t s??? gi??y, l??c n??y:
            //  - gi???m s??? ph??t xu???ng 1 ????n v???
            //  - thi???t l???p s??? gi??y l???i 59
            if (s === -1) {
                m -= 1;
                s = 59;
            }

            // N???u s??? ph??t = -1 t???c l?? ???? ch???y ng?????c h???t s??? ph??t, l??c n??y:
            //  - gi???m s??? gi??? xu???ng 1 ????n v???
            //  - thi???t l???p s??? ph??t l???i 59
            if (m === -1) {
                h -= 1;
                m = 59;
            }

            // N???u s??? gi??? = -1 t???c l?? ???? h???t gi???, l??c n??y:
            //  - D???ng ch????ng tr??nh
            if (h == -1) {
                clearTimeout(timeout);
                $(document).ready(function() {

                    $('#do_test').submit();
                });

                return false;
            }

            /*B?????C 1: HI???N TH??? ?????NG H???*/
            document.getElementById('h').innerText = h.toString();
            document.getElementById('m').innerText = m.toString();
            document.getElementById('s').innerText = s.toString();

            /*B?????C 1: GI???M PH??T XU???NG 1 GI??Y V?? G???I L???I SAU 1 GI??Y */
            timeout = setTimeout(function() {
                s--;
                start();
            }, 1000);

            function stop() {
                clearTimeout(timeout);
            }
        }
    </script>
    @if ($score != null)
        <script>
            $(document).ready(function() {
                $("#do_test :input").prop("disabled", true);
            });
        </script>
    @endif
</body>

</html>
