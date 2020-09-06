/************Open all page***********//*
$(document).on("click","#", function(){
    $pid=$(this).data("id");
    all_open("<?php echo site_url('support_model/openmodelsec');?>",$pid);
});*/
$(document).on("click",".change_", function(){
    $('.nav-link').removeClass('active');
    $('.change_sub_link').removeClass('active');
    $(this).addClass('active');
});

$(document).on("click",".back", function(){
    $('.nav-link').removeClass('active');
    $('.change_sub_link').removeClass('active');
    $(this).addClass('active');
    var url = $(this).data('url');
    all_open(url);
});

$(document).on("click",".change_link", function(){
    $('.nav-link').removeClass('active');
    $('.change_sub_link').removeClass('active');
    $(this).addClass('active');
    var url = $(this).data('url');
    all_open(url);
});

$(document).on("click",".change_sub_link", function(){
    $('.change_sub_link').removeClass('active');
    $(this).addClass('active');
    var url = $(this).data('url');
    all_open(url);
});

$(document).on("click",".change_inside_link", function(){
    $('.nav-link').removeClass('active');
    $('.change_sub_link').removeClass('active');
    var back_url = $(this).data("bck");
    var a_tag = $(this).attr("href");
    console.log(a_tag);
    $('li.nav-item a[href*="'+a_tag+'"]').addClass('active');
    var url = $(this).data('url');
    all_open(url,back_url);
});

$(document).on("click","#change_status", function(){
    var url = $(this).data('url');
    var status = $(this).data('input');
    var rowid = $(this).data('rowid');
    var tableid = $(this).data('tblid');
    var obj = {'id' : rowid, 'status' : status}
    swal({
        title: "Are you sure?",
        text: "Want to change status !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            ajax_req(url,obj,tableid);
        } else {
            swal("Your imaginary file is safe!");
        }
    });
});



function all_open(url,backurl = false)
{
    $.ajax({
        url: url,
        type: "POST",
        data: {backurl:backurl},
        dataType:"json",
        success: function(result)
        {
            //toastr['success']("Form open");
            $('#changecontent').html(result.page);
        }
    })
}

/*********Savedata************/
function ajax_req($url,$data,table)
{
    $.ajax({
        url: $url,
        type: "POST",
        data: $data,
        dataType:"json",
        /*beforeSend: function ()
        {
            ajaxindicatorstart('Please Wait...');
        },*/
        success: function(result)
        {
            //ajaxindicatorstop();
            if(result.success==true)
            {
                swal("Good job!", result.message, "success");
                //$('#'+ table).DataTable().ajax.reload();
                $('#datatable').DataTable().ajax.reload();
                //$('#changecontent').html(result.page);
            }
            else if(result.success=="invalid")
            {
                //toastr.error(result.message);
                //$('#changecontent').html(result.page);
            }
            else
            {   
                swal({
                    title: "Error!",
                    text: result.message,
                    icon: "error",
                });
                //toastr.error(result.message);//$('#changecontent').html(result.page);
            }
        }   
    })
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
