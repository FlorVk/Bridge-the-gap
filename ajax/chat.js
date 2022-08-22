
    $(document).on("click","#btn-chat",function(){
        let text = document.querySelector("#input-field").value;
        let outgoing = $(this).attr("data-outgoing");
        let incoming = $(this).attr("data-incoming");
        $.ajax({  
            url:"ajax-chat_message.php",  
            method:"POST",
            data:{
                text: text,
                outgoing: outgoing,
                incoming: incoming,
            },  
            success:function(data){ 
                $('#showcase-success').html(data); 
                $('#showcase-success').addClass("show");
                console.log(text);
                console.log(incoming);
                console.log(outgoing);
                location.reload();
                text.value = "";
            } 
        }); 
    }); 