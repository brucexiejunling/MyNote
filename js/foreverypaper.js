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
            function(papercomments){
                if(papercomments["success"]){
                    $("textarea[name='input_comment']").val('');
                    $("textarea[name='input_comment']").attr('placeholder','提交评论成功');
                    $('div #paper_comments').append(papercomments.msg);
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
             $("#paper_comments_button").val('收起评论框');
             
        }else{
            document.getElementById('fieldset_input_comments').style.display = "none";
            $("#paper_comments_button").val('我想评论这本书');
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
            function(papercomments){
                if(papercomments["success"]){
                    $("textarea[name='input_note']").val('');
                    $("textarea[name='input_note']").attr('placeholder','提交笔记成功');
                    $("input[name='note_page']").val('');
                    $("input[name='note_page']").attr('placeholder','0');
                    $('div #paper_notes').append(papercomments.msg);
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
             $("#paper_notes_button").val('收起笔记框');
        }else{
            document.getElementById('fieldset_input_notes').style.display = "none";
            $("#paper_notes_button").val('我想做笔记');
        }
    }
    $("#input_comments input[type='submit']").live("click", submitcomments);
    $('#fieldset_input_comments').hide();
    $("#paper_comments_button").live("click", addCommentspart);
    $("#fieldset_input_notes input[type='submit']").live("click", submitnotes);
    $('#fieldset_input_notes').hide();
    $("#paper_notes_button").live("click", addNotespart);
});
