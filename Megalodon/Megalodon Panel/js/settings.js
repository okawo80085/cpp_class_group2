function regForm()
{
    $('input[name="prune-dead"]').click(function(e) {
        e.preventDefault();
        if(!confirm("Prune dead bots?"))return;
        $.get('settings.php?prune=1');
        $(this).val("Pruned");
        $(this).attr('disabled','disabled');
        $(this).css({background:'green',cursor:'default'});
    });
    $('input[name="prune-logs"]').click(function(e) {
        e.preventDefault();
        if(!confirm("Prune logs?"))return;
        $.get('settings.php?prune=2');
        $(this).val("Pruned");
        $(this).attr('disabled','disabled');
        $(this).css({background:'green',cursor:'default'});
    });
    saveEvt();
}

function saveEvt()
{
    $('input[name="save"]').click(function (e) {
        e.preventDefault();
        $.post('ajax/settings.php', $('#settings-form').serialize(), function (data) {
            $('#content-out').html('<input type="submit" value="Save" name="save"/> ' + data);
            saveEvt();
        });
    });
}