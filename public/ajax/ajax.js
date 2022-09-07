$(document).ready(function () {



    $("#class_id").change(function () {
        if ($(this.val != '')) {
            var select = $(this).attr('id');
            var value = $("#class_id").val();

            var dependent = $(this).data('dependent');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/getStudent',
                method: "post",
                data: {
                    select: select,
                    value: value,
                    dependent: dependent

                },
                success: function (result) {
                    $("#student_id").html(result);
                }
            })
        }
    })
})
