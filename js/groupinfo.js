$(function(){
    var deleteMember = function(event){
        var that = this;
        $(this).attr("disabled", true);
        $.post(
            $(this).closest('form').attr('action'),
            {
                member_id: $(this).attr('alt')
            },
            function(data){
                if(!data.success){
                    alert(data.msg);
                }else{
                    $(that).closest('div.span').remove();
                    $(that).removeAttr("disabled");
                }
            },
            'json'
        );
        return false;
    }
    
    function Submit_create_group(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        $.post(
            $(this).closest("form").attr("action"),
            {
                creator_id:$(this).closest("form").find("input[name='add_friend_id']").val(),
                groupname:$(this).closest("form").find("input[name='groupname']").val(),
                groupintro:$(this).closest("form").find("input[name='groupintro']").val()
            },
            function(data){
                if(data["success"]){
                   alert("success");
                   $("#my_groups ul").append("<li><h3>"+data["msg"]+"</h3></li>");
                }else{
                    alert(data["msg"]);
                }
            },
            "json"
            );
        return false;
    }
    
    $("#Create_Group_Form input[type='submit']").live("click", Submit_create_group);
    $("button.deletemember").click(deleteMember);
});