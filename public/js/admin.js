$.validator.setDefaults({
    submitHandler: function(e) {
        e.preventDefault();
    }
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success : function(response){
        if ("messages" in response)
        {
            for(var i in response.messages)
            {
                var message = response.messages[i];
                toastr[message.type](message.text);
            }
        }
    }
});

$(document).ready(function(){
    $("#signout").click(function(){
        $.ajax({
            url: "/api/admin/signout"          
        }).done(function(){
            setTimeout(function(){
                window.location.href = "/admin/";
            }, 1000)
        });
    });
    
    $("form").submit(function(e){
        e.preventDefault();
        var data = {};
        $(this).find("[data-field]").each(function(index, value){
            val = ["checkbox", "radio"].indexOf($(value).attr("type")) + 1 ? $(value).prop("checked") : $(value).val();
            val = val ? val : "";
            data[$(value).data("field")] = val;
        });
        console.log(data);  
        $.ajax({
            url : "/api" + $(this).attr("action"),
            method : "post",
            data : data,
            success : function() {
               window.location.reload();
            }
        });
    });

    $("[data-delete]").click(function(){
        $.ajax({
            url : "/api/admin/delete-" + $(this).data("delete"),
            method : "post",
            data : {
                id : $(this).data("id")
            },
            success : function(response) {
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }
        });
    });

    $("[data-check]").click(function(){
        console.log( $(this).form );
        $(this).closest("form").submit();
    });

});