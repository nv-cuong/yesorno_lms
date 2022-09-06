<html>

<head>
@include('admin.tests.bootstrap5')
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
</style>
<body>
    <?php $q=1?>
    <h1> Test 1</h1>
   
    <form id="myForm" method="post" action="{{ route('test.save_maked',[$tests->id,$user->id]) }}">
        @csrf
        <div class="container">
        <div class='py'>
    
        @foreach($tests->question as $question)
        <h5> Câu
            <?php echo $q;?>
            :
            {{ $question->content}}
        </h5>
        <label>
        <?php 
$answer=$answers->where('question_id','like',$question->id);

if ($question->category==2) {
    $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,1]);
    if ($users_test==null) {
        echo '<label><input name="q'.$q.'[]" type="radio" value="1" />  A) Đúng </BR></label>';
    } else {
        echo '<label><input name="q'.$q.'[]" type="radio" value="1" checked />  A) Đúng </BR></label>';
    }
    $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,0]);
    if ($users_test==null) {
        echo '<label><input name="q'.$q.'[]" type="radio" value="0" />  B) Sai </BR></label>';
    }
    else {
        echo '<label><input name="q'.$q.'[]" type="radio" value="0" checked/>  B) Sai </BR></label>';
    }
}
if ($question->category==0) {
    $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and question_id = ?", [$user->id,$question->id]);
    foreach ($users_test as $users_test) {
        echo '<textarea class="form-control "
   value="" name="q'.$q.'" id="exampleFormControlTextarea1"placeholder="nhập câu trả lời"
   rows="3">'.$users_test->answer.'</textarea>
   <label for="exampleFormControlInput1">Nhập điểm</label>
   <input type="" name="point" class="form-control "
        placeholder="nhập điểm">';
    }
}
else{
   $k=1;
   foreach ($answer as $answer) {
if ($k==1) {
    $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,$answer->id]);
    if ($users_test==null) {
        echo '<label><input name="q'.$q.'[]" type="radio" value="'.$answer->id.'"/>  A) '.$answer->content.' </BR></label>';
    } else {
        echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'" checked/> A) '.$answer->content.' </BR></label>';
    }
}

       if ($k==2) {
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,$answer->id]);
        if ($users_test==null) { 
        echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'" />  B) '.$answer->content.' </BR></label>';
        }
        else{
            echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'"checked />  B) '.$answer->content.' </BR></label>';
        }
    }
       if ($k==3) {
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,$answer->id]);
        if ($users_test==null) { 
        echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'" />  C) '.$answer->content.' </BR></label>';
        }
        else{
            echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'"checked />  C) '.$answer->content.' </BR></label>';
        }
       }
       if ($k==4) {
        $users_test = DB::select("SELECT * FROM user_test_answers where user_test_id = ? and answer = ?", [$user->id,$answer->id]);
        if ($users_test==null) { 
        echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'" />  D) '.$answer->content.' </BR></label>';
        }
        else{
            echo '<label><input name="q'.$q.'" type="radio" value="'.$answer->id.'" checked/>  D) '.$answer->content.' </BR></label>';
        }
       }
       $k++;
   }
}

?><?php $q++;?>
<hr>
</label>
        @endforeach
        <button type="submit" class="btn btn-primary">Chấm điểm</button></BR>
        <?php
if ($diem!="bạn chưa có kết quả") {
    echo'
        <h6>Bạn đã được số điểm là: '.$diem.'</h6>';
}?>
       
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?php
    if($diem!="bạn chưa có kết quả"){
      echo '<script>
    
      $(document).ready(function(){
        $("#myForm :input").prop("disabled", true);
    });
</script>';
    }
    ?>
</body>

</html>