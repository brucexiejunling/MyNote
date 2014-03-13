$(function(){
    function submitLoginInfo(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        $.post(
            $(this).closest("form").attr("action"),
            {
                email:$(this).closest("form").find("input[name='email']").val(),
                password:$(this).closest("form").find("input[name='password']").val()
            },
            function(data){
                if(data["success"]){
                    //$(".topbar ul.secondary-nav").html(data["msg"]);
                    window.location.reload();
                }else{
                    alert(data["msg"]);
                }
                $(this).removeAttr('diabled');
            },
            "json"
            );
        return false;
    }
    function submitSignUpInfo(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        $.post(
            $(this).closest("form").attr("action"),
            {
                newemail:$(this).closest("form").find("input[name='newemail']").val(),
                newpassword:$(this).closest("form").find("input[name='newpassword']").val(),
                newpassword_again:$(this).closest("form").find("input[name='newpassword_again']").val(),
                newnickname:$(this).closest("form").find("input[name='newnickname']").val()
            },
            function(data){
                if(data["success"]){
                    //alert("Success!Welcome to Mynotes");
                    //$(".topbar ul.secondary-nav").html(data["msg"]);
                    window.location.reload();
                }else{
                    alert(data["msg"]);
                }
                $(this).removeAttr('diabled');
            },
            "json"
            );
        return false;
    }
    function Submit_modify_password(event){
        event.preventDefault();
        $.post(
            $(this).closest("form").attr("action"),
            {
                pre_password:$(this).closest("form").find("input[name='pre_password']").val(),
                new_password:$(this).closest("form").find("input[name='new_password']").val(),
                new_password_again:$(this).closest("form").find("input[name='new_password_again']").val()
            },
            function(data){
                if(data["success"]){
                    alert(data["msg"]);
                    $("input[type='password']").val("");
                }else{
                    alert(data["msg"]);
                }
            },
            "json"
            );
        return false;
    }
    
    function Submit_modify_nickname(event){
        event.preventDefault();
       
        $(this).attr('diabled', true);
        $.post(
            $(this).closest("form").attr("action"),
            {
                email:$(this).closest("form").find("input[name='email2']").val(),
                nickname:$(this).closest("form").find("input[name='nickname']").val()
            },
            function(data){
                if(data["success"]){
                    alert("success");
                    $(".topbar ul.secondary-nav").html(data["msg"]);
                    
                    $(this).attr('diabled', false);
                }else{
                    alert(data["msg"]);
                }
            },
            "json"
            );
        return false;
    }
    function Submit_add_friend(event){
        event.preventDefault();
        $(this).attr('diabled', true);
        $.post(
            $(this).closest("form").attr("action"),
            {
                add_friend_id:$(this).closest("form").find("input[name='add_friend_id']").val()
            },
            function(data){
                if(data["success"]){
                    $(".friend_control").html(data["msg"]);
                }else{
                    alert(data["msg"]);
                }
            },
            "json"
            );
        return false;
    }
    function Submit_delete_friend(event){
        event.preventDefault();
        $(this).attr('diabled', false);
        $.post(
            $(this).closest("form").attr("action"),
            {
                friend_id:$(this).closest("form").find("input[name='friend_id']").val()
            },
            function(data){
                if(data["success"]){
                    $(".friend_control").html(data["msg"]);
                }else{
                    alert(data["msg"]);
                }
            },
            "json"
            );
        return false;
    }
    function updateTopbar(){
        $.get(
            base_url+"index.php/usermanager/topbarstatus",
            function(data){
                $(".topbar ul.secondary-nav").html(data);
            }
            );
    }
    
    function logout(){
        $.get(
            $(this).attr("href"),
            function(data){
                $(".topbar ul.secondary-nav").html(data);
                window.location.reload();
            }
        );
        return false;
    }
        
    updateTopbar();
    $("#loginForm input[type='submit']").live("click", submitLoginInfo);
    $("#signupForm input[type='submit']").live("click", submitSignUpInfo);
    $("a.logout").live("click", logout);
    $("#Modify_Password_Form input[type='submit']").live("click", Submit_modify_password);
    $("#Modify_Nickname_Form input[type='submit']").live("click", Submit_modify_nickname);
    $("#Add_Friend_Form input[type='submit']").live("click", Submit_add_friend);
    $("#Delete_Friend_Form input[type='submit']").live("click", Submit_delete_friend);
});
