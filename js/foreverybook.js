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
            function(bookcomments){
                
                if(bookcomments.success){
                    $("textarea[name='input_comment']").val('');
                    $("textarea[name='input_comment']").attr('placeholder','提交评论成功');
                    $('div #book_comments').append(bookcomments.msg);
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
            $("#book_comments_button").val('收起评论框');
             
        }else{
            document.getElementById('fieldset_input_comments').style.display = "none";
            $("#book_comments_button").val('我想评论这本书');
        }
    }
    function submitnotes(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        var that = this;
        $.post(
            $("#input_comments").attr("action"),
            {
                notes:$(this).closest("fieldset").find("textarea[name='input_note']").val(),
                page_num:$(this).closest("fieldset").find("input[name='note_page']").val(),
                for_group: $(this).closest("fieldset").find("input[name='for_group']").is(":checked")? 1:0
                
            },
            function(bookcomments){
                if(bookcomments["success"]){
                    $("textarea[name='input_note']").val('');
                    $("textarea[name='input_note']").attr('placeholder','提交笔记成功');
                    $("input[name='note_page']").val('');
                    $("input[name='note_page']").attr('placeholder','0');
                    $('div #book_notes').append(bookcomments.msg);
                }else{
                    $("textarea[name='input_note']").val('');
                    $("textarea[name='input_note']").attr('placeholder','提交笔记未成功');
                }
                $(this).removeAttr('diabled');
            },
            "json"
            );
        return false;
    }
    
    function addNotespart( event ){
        if( document.getElementById('fieldset_input_notes').style.display === "none" ){
            document.getElementById('fieldset_input_notes').style.display = "block";
            $("#book_notes_button").val('收起笔记框');
        }else{
            document.getElementById('fieldset_input_notes').style.display = "none";
            $("#book_notes_button").val('我想做笔记');
        }
    }

    $("#input_comments input[type='submit']").live("click", submitcomments);
    document.getElementById('fieldset_input_comments').style.display = "none";
    $("#book_comments_button").live("click", addCommentspart);
    $("#fieldset_input_notes input[type='submit']").live("click", submitnotes);
    document.getElementById('fieldset_input_notes').style.display = "none";
    $("#book_notes_button").live("click", addNotespart);
});
