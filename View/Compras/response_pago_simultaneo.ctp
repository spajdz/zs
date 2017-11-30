<form action="<?=$estadoTransaccion['url_comprobante'];?>" id="form_comprobante">
	<input type="hidden" name="token_ws" value="<?=$estadoTransaccion['token_ws'];?>">
</form>
<script type="text/javascript">
	document.getElementById('form_comprobante').submit();
</script>

