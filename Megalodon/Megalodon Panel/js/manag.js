function regDelete()
{
    var del = $('.delete');
    del.click(function(){
        if(!confirm("Delete this user?"))return;
        var index = del.index(this);
        $.get('management.php?delete='+$(this).attr('id'));
        del.eq(index).closest('tr').remove();
    });
}

function regForm()
{
    $('input[name="action"]').click(function(e){
        e.preventDefault();
        $.post('ajax/user.php',$('#user-form').serialize()+"&action="+$('input[name="action"]').val(),function(data){
            $('.user-result').html(data);
        });
    });
}

function regMod()
{
    var edt = $('.edit');
    edt.click(function(){
        var index = edt.index(this);
        $('.user-title').html('Edit User');
        $('input[name="id"]').val(edt.eq(index).closest('td').prev().prev().prev().html());
        $('input[name="username"]').val(edt.eq(index).closest('td').prev().prev().html());
        $('select[name="access"]').val(edt.eq(index).closest('td').prev().html()=="Yes"?1:0);
        $('input[name="action"]').val("Modify User");
        $('.user-result').html("<font color='white'>Leave the password blank if you don't want to change it</font>");
    });
}