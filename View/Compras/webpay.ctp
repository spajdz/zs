<form id="webpay" action="<?= $webpay['gateway']; ?>" method="POST">
	<input type="hidden" name="TBK_TIPO_TRANSACCION" value="TR_NORMAL">
	<input type="hidden" name="TBK_ORDEN_COMPRA" value="<?= $webpay['oc']; ?>">
	<input type="hidden" name="TBK_MONTO" value="<?= $webpay['monto']; ?>">
	<input type="hidden" name="TBK_URL_EXITO" value="<?= $webpay['exito']; ?>">
	<input type="hidden" name="TBK_URL_FRACASO" value="<?= $webpay['fracaso']; ?>">
</form>
<script type="text/javascript">
document.getElementById('webpay').submit();
</script>
