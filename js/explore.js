$(function(){
    var toggleCheckbox = function(){
        if($(this).hasClass("label-active")){
            $("#"+$(this).attr("for")).removeAttr("checked");            
        }else{
            $("#"+$(this).attr("for")).attr("checked", true);
        }
        $(this).toggleClass("label-active");
        clearTimeout(timer);
        timer = setTimeout(function(){
            $(".popover").remove();
            $('#show-ground').html('');
            $("#getmore").click().click();
        }, 1000);
    };
    
    var fetchMoreBooks = function(event){
        var that = this;
        $(that).attr('disabled', true).html('loading...');
        var args = {
            type: [],
            classification: []
        };
        $("input[type='checkbox'][checked='checked']").each(function(){
            args[$(this).attr('name')].push($(this).val());
        });
        args.type = args.type.join('|');
        args.classification = args.classification.join('|');
        $.get(
            base_url+"index.php/explore/ajaxitems",
            args,
            function(data){
                $(that).removeAttr('disabled').html('more');
                $("#show-ground").append(data);
            }
        );
    };
    
    $.extend($.expr[':'], {  
        left: function(a) {  
            return a.offsetLeft < document.body.clientWidth*3/5;  
        },
        right: function(a) {  
            return a.offsetLeft >= document.body.clientWidth*3/5;  
        }
    });
    
    $(".filter .checkbox-set label").click(toggleCheckbox);
    
    $(".filter .checkbox-set").each(function(index,checkboxset){
        $(checkboxset).find("label:first").addClass("first-label");
        $(checkboxset).find("label:last").addClass("last-label");
    });
    
    $("#show-ground a[rel=popover]:left").popover({
        animate: false,
        delayIn: 200,
        delayOut: 200,
        live: true,
        offset: 10
    });
    $("#show-ground a[rel=popover]:right").popover({
        animate: false,
        delayIn: 200,
        delayOut: 200,
        live: true,
        offset: 10,
        placement: 'left'
    })
    var timer;
    $("#getmore").click(fetchMoreBooks);
    $("#getmore").click().click();
    
})