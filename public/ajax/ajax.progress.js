$(document).ready(function () {



    $(window).scroll(function (event) {
            var pos_body = $('html,body').scrollTop()
            var select = $(this).attr('id');
            var value = 1;
            var dependent = $(this).data('dependent');
            if (pos_body > 50) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/lessonProgress',
                    method: "POST",
                    data: {
                        select:select,
                        value: value,
                        dependent:dependent
                    },
                })
            }
    })
})
