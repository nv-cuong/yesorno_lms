$(document).ready(function () {



    $("#class_id").change(function () {
       
        if ($(this.val != '')) {
            
            var id = $("#class_id").val();
            var url = "{{ route('test1', ':id') }}",
            url = url.replace(':id', id);
          $.ajax({
      
            type: 'GET',
            url: '/getStudent/1',
            success: function(data) {
                console.log(data);
                $(".student_id").html(data);
      
            },
            error: function(data) {
              console.log(data);
            }
          });
            
            
            
        }
    })
})
