<?php
global $userpro;

$intUserid = intval( get_query_var('up_username', get_current_user_id()) );
$objUserinfo = get_user_by('id', $intUserid);
$strControlNumber = get_control_number("claim");

$arrProducts = get_product_details();
?>

<div class="modal fade" id="claim-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">New Claim</h4>
      </div>
      <form method="POST" action="<?php echo get_template_directory_uri() . "/post-processor.php" ?>" onsubmit="return validateForm()">
      <div class="modal-body">
      		<input type="hidden" name ="posttype" id="postype" value="newclaim">
			<input type="hidden" name ="userid" id="userid" value="<?php echo $intUserid?>">
			<div class="container claim-form">								
				<div class="col-xs-2">
					<br/>							
					<span class="modal-label">REFERENCE NUMBER</span>
					<p><?php echo $strControlNumber; ?></p>
				</div>
				<div class="col-xs-3">
					<br/>							
					<span class="modal-label">PRODUCT</span>
					<select name="product_id" id="product_id" class="form-control">
						<option>Select product</option>
						<?php 
							foreach ($arrProducts as $objProduct)
							{
								echo '<option value="'. $objProduct->id .'">'. $objProduct->product_details .'</option>';
							}
						?>
					</select>					
				</div>
				<div class="col-xs-2">
					<br/>							
					<span class="modal-label">AMOUNT</span>
					<input type="text" name="product_amount" value="" placeholder="0" class="form-control" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<p>&nbsp;</p>
					<hr/>
					<button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
        			<button class="btn btn-primary pull-right" type="submit">Save</button>   
				</div>
			</div>	   
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

							
<script type="text/javascript">
(function($) {
	$(document).ready(function(){
		$("[name='points']").bootstrapSwitch();							

		$("#referrer").change(function(){
			var SelectedValue = $(this).children("option:selected").val();
			if(SelectedValue > 0)
			{
				jQuery("#referrer_cash_rate, #referrer_product_rate").attr("disabled", false);
			}
			else
			{
				jQuery("#referrer_cash_rate, #referrer_product_rate").attr("disabled", true);
			}
		});
	})
})(jQuery);

function validateForm(){
	return true;
}
</script>

<?php
wp_enqueue_script( 'bs-switch', get_template_directory_uri() . '/js/bootstrap-switch.js', array( 'jquery' ) ); 
wp_enqueue_script('jquery-ui-dialog');
?>