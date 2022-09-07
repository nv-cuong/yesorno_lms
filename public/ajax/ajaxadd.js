$(document).ready(function() {



    $(".course").change(function() {
        if ($(this.val != '')) {
            var select = $(this).attr('id');
            var value = $(".course").val();
            var dependent = $(this).data('dependent');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/getQuestion',
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    dependent: dependent

                },
                success: function(result) {
                    $(".question").html(result);
                }
            })
        }
    })
})



// var url = "{{ url('/showQuestionInCourse') }}";
// $("select[name='course_id']").change(function() {

//     var id = $(".course_id").val();
//     var token = $("input[name='_token']").val();

//     // $.post("data.php", { id: id }, function(data) {
//     //     $(".question").html(data);
//     $.ajax({
//         url: url,
//         method: 'POST',
//         data: {
//             id: id,
//             _token: token
//         },

//         success: function(data) {
//             $("select[name='question']").html('');
//             $.each(data, function(key, value) {
//                 $("select[name='question']").append(
//                     "<option value=" + value.id + ">" + value.title + "</option>"
//                 );
//             });
//         }

//     })
//     alert(token);

// });