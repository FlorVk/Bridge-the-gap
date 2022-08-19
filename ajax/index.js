$(document).on("click","#btnAddLike",function(){
    console.log("press");
    //$("#btnAddDislike").show();
    //$("#btnAddLike").hide();
    $.ajax({  
        url:"ajax-add_like.php",  
        method:"POST",
        data:{
            post: $(this).attr("data-postid"),
        },  
        success:function(data){ 
            $('#showcase-success').html(data); 
            $('#showcase-success').addClass("show");
            location.reload();
        } 
    }); 
}); 

$(document).on("click","#btnAddUnlike",function(){
    console.log("pressing");
    //$("#btnAddDislike").show();
    //$("#btnAddLike").hide();
    $.ajax({  
        url:"ajax-remove_like.php",  
        method:"POST",
        data:{
            post: $(this).attr("data-postid"),
        },  
        success:function(data){ 
            $('#showcase-success').html(data); 
            $('#showcase-success').addClass("show");
            location.reload();
        } 
    }); 
}); 

$(document).on("click","#btnAddTip",function(){
    $.ajax({  
        url:"ajax-add_tip.php",  
        method:"POST",
        data:{
            post: $(this).attr("data-postid"),
        },  
        success:function(data){ 
            $('#showcase-success').html(data); 
            $('#showcase-success').addClass("show");
            location.reload();
        } 
    }); 
}); 

$(document).on("click","#btnAddUntip",function(){
    $.ajax({  
        url:"ajax-remove_tip.php",  
        method:"POST",
        data:{
            post: $(this).attr("data-postid"),
        },  
        success:function(data){ 
            $('#showcase-success').html(data); 
            $('#showcase-success').addClass("show");
            location.reload();
        } 
    }); 
}); 