$(document).ready(function() {
    $("#sendOtp").click(function(e) {
        e.preventDefault();
        $("#user_mobile_error").html("");
        $("#user_mobile").css("border-color", "green");
        var mobile = $("#user_mobile").val();
        var patt1 = /[0-9]/g;
        if (mobile == ""){
            $("#user_mobile_error").html("Please enter mobile");
            $("#user_mobile").css("border-color", "red");
            return false;
        }
        else if (!mobile.match(patt1)){
            $("#user_mobile_error").html("Only Number are allowed");
            $("#user_mobile").css("border-color", "red");
            return false;
        }
        else if (!(mobile.length == 10)){
            $("#user_mobile_error").html("Enter 10 digit mobile no.");
            $("#user_mobile").css("border-color", "red");
            return false;
        }
        localStorage.setItem("mobile", mobile);
        var postdata = $("#user_form").serialize();
        ajax_req_sent(postdata,'Send_otp');
        return false;
    });

    $(document).on("click","#verifyOtp",function(e){
        e.preventDefault();
        $("#user_mobile_error").html("");
        $("#user_otp").css("border-color", "green");
        var token = $("#token_val").val();
        var otp = $("#partitioned").val();
        var mobile = localStorage.getItem("mobile");
        
        if (otp == ""){
            $("#user_otp_error").html("Please enter mobile");
            $("#partitioned").css("border-color", "red");
            return false;
        }
        var obj = {'csrf_phanuman_name': token,'user_otp':otp,'mobile': mobile};
        ajax_req_sent(obj,'verify_otp');
        return false;
    });

    $(document).on("click","#resend_otp",function(e){
        e.preventDefault();
        var mobile = localStorage.getItem("mobile");
        var token = $("#token_val").val();
        var obj = {'csrf_phanuman_name': token,'mobile': mobile};
        ajax_req_sent(obj,'resend_otp');
        return false;
    });

    $(document).on("click","#save_info",function(e){
        e.preventDefault(); 
        var patt = /^[a-zA-Z ]+$/i;
        var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
         
        $("#name_error").html("");
        $("#name").css("border-color", "green");
        $("#email_error").html("");
        $("#email").css("border-color", "green");

        var token = $("#token_val").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var mobile = localStorage.getItem("mobile");
        if (name == ""){
            $("#name_error").html("Please enter mobile");
            $("#name").css("border-color", "red");
            return false;
        }else if(!name.match(patt)){
            $("#name_error").html("Invalid Name");
            $("#name").css("border-color", "red");
            return false;
        }
        if (email == ""){
            $("#email_error").html("Please enter mobile");
            $("#email").css("border-color", "red");
            return false;
        }
        else if (!filter.test(String(email).toLowerCase())){
            $("#email_error").html("Invalid Email");
            $("#email").css("border-color", "red");
            return false;
        }
        var obj = {'csrf_phanuman_name': token,'name':name,'email': email,'mobile': mobile};
        ajax_req_sent(obj,'Userdetails');
        return false;
    });

    function ajax_req_sent(postdata,url){
        $.ajax({
            url: base_url + url,
            type: "POST",
            data:postdata,
            dataType:"json",
            beforeSend: function ()
            {
                ajaxindicatorstart('Please Wait...');
            },
            success:function(res){
                ajaxindicatorstop();
                $('input[name="csrf_phanuman_name"]').val(res.hash);
                if(res.success == true){
                    if(res.req == 'redirect'){
                        localStorage.removeItem("mobile");
                        swal({
                            title: "Success!",
                            text: res.message,
                            icon: "success",
                        }).then((value) => {
                            window.location.href = res.re_url;
                        });
                    }
                    else{
                        swal({
                            title: "Success!",
                            text: res.message,
                            icon: "success",
                        }).then((value) => {
                            $("#showpages").html(res.page);
                        });
                    }
                }
                else {
                    if(typeof res.message === 'object'){
                        $.each(res.message, function(key, value) {
                            $('#' + key + '_error').html(value);
                        });
                    }else{
                        swal({
                            title: "Error!",
                            text: res.message,
                            icon: "error",
                        });
                    }
                }
            }
        });
    }
});

$(document).on("click","#next_que",function(e){
    e.preventDefault();
    if ($('input[name="opt_answer"]:checked').length != 0){
        var postdata = $("#quiz_form").serialize();
        ajax_req_qus(postdata,'User_attempt_que');
    }else{
        swal({
            title: "Error!",
            text: 'Select any one answer',
            icon: "error",
        });
    }
    return false;
});

$(document).on("click","#submit_quiz",function(e){
    e.preventDefault();
    if ($('input[name="opt_answer"]:checked').length != 0){
        var postdata = $("#quiz_form").serialize();
        ajax_req_qus(postdata,'Quiz_finish');
    }else{
        swal({
            title: "Error!",
            text: 'Select any one answer',
            icon: "error",
        });
    }
    return false;
});

function ajax_req_qus(postdata,url){
    $.ajax({
        url: base_url + url,
        type: "POST",
        data:postdata,
        dataType:"json",
        beforeSend: function ()
        {
            ajaxindicatorstart('Please Wait...');
        },
        success:function(res){
            ajaxindicatorstop();
            $('input[name="csrf_phanuman_name"]').val(res.hash);
            if(res.success == true){
                $("#attempt").text( res.attempt_count+1 +'/'+ res.total_ques);
                if(res.quiz == 'complete'){
                    swal({
                        title: "Success!",
                        text: res.message,
                        icon: "success",
                    }).then((value) => {
                        window.location.href = res.re_url;
                    });
                }else{
                    $("#questions").html(res.page);
                }
            }
            else {
                if(typeof res.message === 'object'){
                    $.each(res.message, function(key, value) {
                        $('#' + key + '_error').html(value);
                    });
                }else{
                    swal({
                        title: "Error!",
                        text: res.message,
                        icon: "error",
                    });
                }
            }
        }
    });
}


/*-------------Ajax loader--------------*/
function ajaxindicatorstart(text)
{
    if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
        jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src='+loader+'><div>'+text+'</div></div><div class="bg"></div></div>');
    }
    jQuery('#resultLoading').css({
        'width':'100%',
        'height':'100%',
        'position':'fixed',
        'z-index':'10000000',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto'
    });
    jQuery('#resultLoading .bg').css({
        'background':'#000000',
        'opacity':'0.7',
        'width':'100%',
        'height':'100%',
        'position':'absolute',
        'top':'0'
    });
    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height':'75px',
        'text-align': 'center',
        'position': 'fixed',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto',
        'font-size':'16px',
        'z-index':'10',
        'color':'#ffffff'
    });
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop()
{
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}
