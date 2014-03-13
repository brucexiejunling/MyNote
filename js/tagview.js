$(function(){
    var toggleInput = function(event){
        var that = this;
        if($(this).siblings('input[name="newtag"]').is(":hidden")){
            $(this).siblings('input[name="newtag"]').show();
            $(this).attr('value','submit');
        }else{
            if($(this).siblings('input[name="newtag"]').val()==""){
                alert('you should type something in the box');
                return false;
            }
            $(this).attr("disabled", true);
            $.post(
                $(this).closest('form').attr('action'),
                {newtag:$(this).siblings('input[name="newtag"]').val()},
                function(data){
                    if(data.success){
                        $('div.tag_row').append(data.msg);
                        $(that).siblings('input[name="newtag"]').hide();
                        $(that).attr('value','add new tag');
                        $(that).siblings('input[name="newtag"]').val("");
                    }else{
                        alert(data.msg);
                    }
                    $(that).removeAttr('disabled');
                },
                'json'
             );
        }
        return false;
    }
    
    var up = function(){
        var that = this;
        $.post(
            base_url+'index.php/tag/up/'+$(this).attr('target_type')+'/'+$(this).attr('target_id')+'/'+$(this).attr('alt'),
            function(data){
                if(data.success){
                    $(that).removeClass('notice');
                    $(that).html(data.msg);
                }else{
                    alert(data.msg);
                }
            },
            'json'
        )
    }
    
    $('#tagcontroller').click(toggleInput);
    $('.tag.notice').click(up);
})