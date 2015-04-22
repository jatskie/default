<?php
global $userpro;

$intUserid = intval( get_query_var('up_username', get_current_user_id()) );
$strControlNumber = get_payin_control_number();
$objUserinfo = get_user_by('id', $intUserid);
$arrReferrers = get_referrers();

// Previous payin data
$objPreviousPayinData = get_previous_payin($intUserid);
$strPreviousPayin = format_number($objPreviousPayinData->amount);
$strPreviousPayout = get_previous_last_payout($intUserid);

// Get active scheme
$arrScheme = array();
$arrSchemes = get_payin_schemes();
foreach ($arrSchemes as $scheme)
{
	$arrScheme = $scheme;
}
?>

<div class="modal fade" id="payin-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">New Payin (<?php echo $arrScheme['description']?>)</h4>
      </div>
      <form method="POST" action="<?php echo get_template_directory_uri() . "/post-processor.php" ?>" onsubmit="return validateForm()">
      <div class="modal-body">       
			<div class="payin-form">
				<div class="col-xs-12">
					<div class="row new-payin-center">
						<div class="col-xs-3">
							<br/>							
							<span class="modal-label">REFERENCE NUMBER</span>
							<p><?php echo $strControlNumber; ?></p>
						</div>
						<div class="col-xs-3">
							<br/>
							<span class="modal-label">ACCOUNT NAME</span>
							<p><?php echo  $objUserinfo->display_name ?></p>
						</div>
						<div class="col-xs-6">
							<div class="alert alert-success row">
								<div class="col-xs-6">
									<span class="modal-label">INITIAL INVESTMENT</span>
									<p>P<?php echo $strPreviousPayin?></p>
								</div>
								<div class="col-xs-6">
									<span class="modal-label">LAST PAY-OUT</span>
									<p>P<?php echo $strPreviousPayout?></p>
								</div>
								
							</div>
						</div>
					</div>					
					<input type="hidden" name ="posttype" id="postype" value="newpayin">
					<input type="hidden" name ="userid" id="userid" value="<?php echo $intUserid?>">
					<input type="hidden" name ="scheme" id="scheme" value="<?php echo $arrScheme['value']?>" />
				</div>
				<hr/>
				<div class="row">
					<div class="col-xs-6">
						<span class="modal-label">Pay-In Amount</span>
						<input type="text" class="form-control" name="amount" id="amount" />									
					</div>
					<div class="col-xs-6">
						<div class="row">
							<div class="col-xs-4">
								<span class="modal-label">Rate</span>
							    <div class="input-group">
							      	<input type="text" name="rate" id="rate" class="form-control" aria-label="rate" value="<?php echo $arrScheme['rate']?>">
							      	<span class="input-group-addon">
							        	%
							      	</span>
							    </div>
							</div>
						    <div class="col-xs-4">
							    <span class="modal-label">Split</span>
							    <div class="input-group">
							      	<input type="text" name="split" id="split" class="form-control" aria-label="split" value="<?php echo $arrScheme['split']?>">
							      	<span class="input-group-addon">
							        	X
							      	</span>
							    </div>
							</div>
							<div class="col-xs-4">
								<span class="modal-label">Points</span>
								<input type="checkbox" name="points" id="points" value="1" />
							</div>
						</div>
					</div>
				</div>
				
				<div class="row referrer-box">
					<div class="col-xs-6">
						<span class="modal-label">Referred by:</span>
						<select name="referrer" id="referrer" class="form-control">
							<option value="0">Select referrer name</option>
							<?php 
								foreach ($arrReferrers as $arrReferrer)
								{
									echo '<option value="'. $arrReferrer['value'] .'">'. $arrReferrer['name'] .'</option>';
								}
							?>
						</select>
						<div class="row">
							<div class="col-xs-4">
								<span class="modal-label">Cash Rate</span>
							    <div class="input-group">
							      	<input type="text" name="referrer_cash_rate" id="referrer_cash_rate" class="form-control" aria-label="rate" value="<?php echo $arrScheme['referrer_cash_rate']?>">
							      	<span class="input-group-addon">
							        	%
							      	</span>
							    </div>
							</div>
						    <div class="col-xs-4">
							    <span class="modal-label">Product Rate</span>
							    <div class="input-group">
							      	<input type="text" name="referrer_product_rate" id="referrer_product_rate" class="form-control" aria-label="split" value="<?php echo $arrScheme['referrer_product_rate']?>">
							      	<span class="input-group-addon">
							        	%
							      	</span>
							    </div>
							</div>
							<div class="col-xs-4">
								<span class="modal-label">Tax Rate</span>
							    <div class="input-group">
							      	<input type="text" name="tax_rate" id="tax_rate" class="form-control" aria-label="rate" value="10.00" disabled>
							      	<span class="input-group-addon">
							        	%
							      	</span>
							    </div>
							</div>
						</div>					
				    </div>
				    
				    <div class="col-xs-6 payin-type">
				    	<label class="radio-inline">
				  			<input type="radio" name="type" id="it_cash" value="1" checked> Cash
						</label>
						<label class="radio-inline">
				  			<input type="radio" name="type" id="it_cheque" value="2"> Cheque
						</label>
				    </div>
				</div>
				<div id="submit-error" class="alert alert-danger hidden"></div>			
			</div>
      </div>
      <div class="modal-footer">      	
        <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary">Save</button>        
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
	var rate = jQuery("#rate").val(),
	    split = jQuery("#split").val(),
	    amount = jQuery("#amount").val(),
	    referrer = jQuery("#referrer option:selected").val(),
	    referrer_cash_rate = jQuery("#referrer_cash_rate").val(),
	    referrer_product_rate = jQuery("#referrer_product_rate").val();

	var htmlError = "<ul>";
	var intErrorCount = 0;
	
	if( "" == rate)
	{				
		htmlError += "<li>Rate is a required field.</li>";
	    intErrorCount++;
	}

	if( "" == split )
	{
		htmlError += "<li>Split is a required field</li>";
		intErrorCount++;
	}

	if( "" == amount )
	{
		htmlError += "<li>Amount is a required field.</li>";
		intErrorCount++;
	}

	if( referrer > 0)
	{
		if("" == referrer_cash_rate)
		{
			htmlError += "<li>Referrer active. Cash rate is required.</li>";
			intErrorCount++;
		}		

		if( "" == referrer_product_rate)
		{
			htmlError += "<li>Referrer active. Product rate is required.</li>";
			intErrorCount++;
		}		
	}

	htmlError += "</ul>"
	
	if(intErrorCount > 0)
	{
		jQuery("#submit-error").removeClass("hidden").html(htmlError);
		return false;
	}
	else
	{
		return true;
	}
}
</script>

<?php
wp_enqueue_script( 'bs-switch', get_template_directory_uri() . '/js/bootstrap-switch.js', array( 'jquery' ) ); 
wp_enqueue_script('jquery-ui-dialog');
?>