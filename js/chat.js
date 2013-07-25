$(function()
{
	$('body').delegate('.mensajeEnviar','keydown', function(e)
	{
		var campo=$(this);
		var mensaje = $(this).val();
		var to  = $(this).attr('id');
		if(e.keyCode==13)
		{
			if(mensaje !='')
			{
				$.post('sys/chat.php',{
					acc:'insertar',
					mensaje: mensaje,
					para: to
				},function(retorno)
				{
					$('#jan_'+to+' ul.lista').append(retorno);
					campo.val('');
				});
				campo.val('');
			}
		}
	});
});