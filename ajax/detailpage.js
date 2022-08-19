document.querySelector("#btnAddComment").addEventListener("click", function() {
    let postId = this.dataset.postid;
    let text = document.querySelector("#commentText").value;

    event.preventDefault();
    console.log(postId);
    console.log(text);

    const formData = new FormData();

    formData.append('text', text);
    formData.append('postId', postId);

    fetch('ajax-add_comment.php', {
    method: 'POST',
    body: formData
    })
    .then(response => response.json())
    .then(result => {
        let newComment = document.createElement('ul');
        newComment.innerHTML = result.data.user + ": " + result.data.comment;
        document.querySelector(".commentsList").appendChild(newComment);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
    }); 

    $(document).on("click","#btnAddLike",function(){
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