$(function(){
    function submitcomments(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        var that = this;
        $.post(
            $(this).closest("form").attr("action"),
            {
                comments:$(this).closest("form").find("textarea[name='input_comment']").val()
            },
            function(webpagecomments){
                
                if(webpagecomments["success"]){
                    $("textarea[name='input_comment']").val('');
                    $("textarea[name='input_comment']").attr('placeholder','提交评论成功');
                    $('div #webpage_comments').append(webpagecomments.msg);
                }else{
                    $("textarea[name='input_comment']").val('');
                    $("textarea[name='input_comment']").attr('placeholder','提交评论失败');
                }
                $(this).removeAttr('diabled');
            },
            "json"
        );
        return false;
    }
    
    function addCommentspart( event ){
        if( document.getElementById('fieldset_input_comments').style.display === "none" ){
             document.getElementById('fieldset_input_comments').style.display = "block";
             $("#webpage_comments_button").val('收起评论框');
             
        }else{
            document.getElementById('fieldset_input_comments').style.display = "none";
            $("#webpage_comments_button").val('我想评论这本书');
        }
    }

  
    $("#input_comments input[type='submit']").live("click", submitcomments);
    document.getElementById('fieldset_input_comments').style.display = "none";
    $("#webpage_comments_button").live("click", addCommentspart);
});
