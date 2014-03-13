$(function(){
    function chooseFile(event){
        $("input[name='upload_avatar']").click();
    }

    function uploadAvatar(event){
        $.ajaxFileUpload({
            url: $(this).closest("form").attr("action"),
            secureuri: false,
            fileElementId: 'upload_avatar',
            dataType: 'json',
            data: {},
            success: function(data, status){
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }else{
                        $("#avatar").attr("src", data.msg);
                    }
                }
            }
        });

    }
    $("#avatar").click(chooseFile);
	$("input[name='upload_avatar']").change(uploadAvatar);
})
