$(document).ready(function()
{
	var janelas=new Array();
	Array.prototype.clean = function(deleteValue)
	{
		for(i=0;i<this.lenght;i++)
		{
			if(this[i] == deleteValue)
			{
				this.splice(i,1);
				i--;
			}
		}
	}
	
	
	
	function add_janela(id,nombre)
	{
		var html_add='<div class="janela" id="jan_'+id+'" ><div class="topo" id="'+id+'"><span>'+nombre+'</span><a href="javascript:void(0);" id="fechar">X</a></div><div id="corpo"><div class="mensajesChat"><ul class="lista"></ul></div><input type="text" class="mensajeEnviar" id="'+id+'" maxlenght="255" /></div></div>';
		$('#janelas').append(html_add);
	}

	//$('.comecar').live('click', function()
	$(document).on("click", ".comecar", function() 
	{
		var id=$(this).attr('id');
		var nombre=$(this).attr('name');
		janelas.push(id);
		janelas.clean(undefined);
		//alert(janelas); //Test
		
		add_janela(id,nombre);
		$(this).removeClass('comecar');

		return false;
	});

	
	$(document).on("click","a#fechar",function()
	{
		var id=$(this).parent().attr('id');
		var parent=$(this).parent().parent().hide();
		$('#contactos a#'+id+'').addClass('comecar');
		
		var n= janelas.length;
		
		for(i=0; i < n; i++)
		{
			if(janelas[i] != undefined)
			{
				if(janelas[i]==id)
				{
					delete janelas[i];
				}
			}
		}
		//alert(janelas);
	});
	
	$(document).delegate('.topo','click',function()
	{
		var pai=$(this).parent();
		if(pai.children('#corpo').is(':hidden'))
		{
			pai.removeClass('fixar');
			pai.children('#corpo').toggle(100);
		}else
		{
			pai.addClass('fixar');
			pai.children('#corpo').toggle(100);		
		}
	});
	
	
	setInterval(function()
	{
		$.post("sys/chat.php",
		{
			acc:'actualizar',
			arreglo:janelas
		},function(x)
		{
			if(x != '')
			{
				for(i in x)
				{
					$('#jan_'+i+' ul.lista').animate({scrollTop:2000});
					$('#jan_'+i+' ul.lista').html(x[i]);
				}
			}
			$('#retorno').html(x);
		
		}, 'jSON');
	},2000);
	
});