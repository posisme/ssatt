
$(function(){
	$(".datepicker").datepicker({dateFormat:"yy-mm-dd","setDate":new Date()});
	
	$("#attdate").change(changespan);
	$("#attdate").val($.datepicker.formatDate("yy-mm-dd",new Date()));
	$("#attdate").change();
	$(".attcheck").click(addatt);
	for(i=0;i<att.length;i++){
		$("#p-"+att[i].individ).append($("<span class='spandate'>"+att[i].attdate+"</span>").click(removespan));
	}
	$("#addstudent").click(addstudent);
});
function removespan(e){
	var event = event || e;
	aratt($(event.target).text(),$(event.target).closest("p").attr('id').replace(/p-/,""),false);
}

function changespan(){
	var d = $.datepicker.formatDate("M d, yy",new Date($("#attdate").val()+" 12:00:00"));
	$(".dtspan").text(d);
}
function aratt(dt,id,ar){
	var url = "submitatt.php?id="+id+"&dt="+encodeURIComponent(dt);
	console.log(url)
	if(ar){
		url += "&mode=add";
	}
	else{
		url += "&mode=remove";
	}
	$.ajax({
		url:url,
		success:function(x){
			console.log(x);
			att.push({individ:id,attdate:$("#attdate").val()});
			if(ar){
				$("#p-"+id).append($("<span class='spandate'>"+$("#attdate").val()+"</span>").click(removespan));
				
			}
			else{
				window.location = window.location;
			}
		},
		error:function(err){
			alert('error');
			console.log(err);
		}
	})
}
function addatt(e){
	var event = event || e;
	if($("#attdate").val() == ""){
		alert("enter date");
		return false;
	}
	var id = $(event.target).attr('id').replace(/checkatt-/,"");
	aratt($("#attdate").val(),id,true);
	$(event.target).removeClass("attcheck");
	$(event.target).addClass("attcheckdone");
}

function addstudent(){
	var data = {};
	$(".addme").each(function(){
		if($(this).attr('type') == "radio"){
			data[$(this).attr('name')] = $("input[name="+$(this).attr('name')+"]:checked").val();
		}
		else{
			data[$(this).attr('id')] = $(this).val();
		}
	});
	for(i in data){
		if(data[i] == ""){
			alert("complete form please");
			return false;
		}
	}
	$.ajax({
		url:"update.php?mode=addperson",
		type:"POST",
		data:data,
		success:function(r){
			//console.log(r);
			window.location = window.location;
		},
		error:function(err){
			alert("error");
			console.log(err);
		}
	})
	console.log(data);
}