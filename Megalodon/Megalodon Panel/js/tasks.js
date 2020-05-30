function regDelete()
{
    var del = $('.delete');
    del.click(function(){
        if(!confirm("Delete this task?"))return;
        var index = del.index(this);
        $.get('tasks.php?delete='+$(this).attr('id'));
        del.eq(index).closest('tr').remove();
    });
}