<?php
/**
 * Template Name: Pay-Ins
 *
 * This is the template that displays New Pay In form
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */
if(is_user_logged_in() == false)
{
	wp_safe_redirect(site_url());
}

get_header();

$intUserid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;

if(0 == $intUserid):
?>
<div class="container">
	<div class="col-xs-12">
		<span class="alert alert-danger">Error: No user has been selected</span>
	</div>
</div>
<?php
else:
	global $userpro;

	$strControlNumber = get_payin_control_number();
	$arrScheme = get_payin_schemes();	
	$objUserinfo = get_user_by('id', $intUserid);
	$profile_url = $userpro->permalink((int)$intUserid);
	$arrReferrers = get_referrers();
?>
<div id="dialog-confirm"></div>
<form method="POST" action="<?php echo $profile_url?>" onsubmit="return validateForm()">
	<div class="payin-form">
		<div class="col-xs-12">
			<h3>Control #: <?php echo $strControlNumber; ?></h3>
			<input type="hidden" name ="posttype" id="postype" value="newpayin">
			<input type="hidden" name ="userid" id="userid" value="<?php echo $intUserid?>">
		</div>
		<div class="row">
			<div class="col-xs-8">
				<label>Name</label>
				<input type="text" class="form-control" name="investor_name" readonly value="<?php echo  $objUserinfo->display_name ?>"/>
				
				<label>Amount (PhP) <i><small>Previous investment: P<?php echo get_previous_payin($intUserid)?></small></i></label>
				<input type="text" class="form-control" name="amount" id="amount" />
				<br/>			
				<label class="radio-inline">
		  			<input type="radio" name="type" id="it_cash" value="1" checked> Cash
				</label>
				<label class="radio-inline">
		  			<input type="radio" name="type" id="it_cheque" value="2"> Cheque
				</label>
			</div>
			<div class="col-xs-4">
				<label>Scheme</</label>
				<select name="scheme" id="scheme" class="form-control">
					<option value="0">Select scheme type</option>
					<?php
						foreach ($arrScheme as $scheme)
						{
							echo '<option value="' . $scheme['value'] . '" 
 										data-rate="' . $scheme['rate'] . '" 
 										data-split="' .$scheme['split']. '"
										data-rcr="' .$scheme['referrer_cash_rate']. '"
										data-rpr="' .$scheme['referrer_product_rate']. '"
								>' . $scheme['name'] . '</option>';
						} 
					?>
				</select>				
				<label>Rate (%)</label>
			    <div class="input-group">
			    	<span class="input-group-addon">
			        	<input type="checkbox" aria-label="Rate" data-target="#rate">
			      	</span>
			      	<input type="text" name="rate" id="rate" class="form-control" aria-label="rate" value="" readonly>
			    </div>
			    
			    <label>Split</label>
			    <div class="input-group">
			    	<span class="input-group-addon">
			        	<input type="checkbox" aria-label="split" data-target="#split">
			      	</span>
			      	<input type="text" name="split" id="split" class="form-control" aria-label="split" value="" readonly>
			    </div><!-- /input-group -->		  
			</div>
		</div>
		
		<div class="row referrer-box">
			<div class="col-xs-12">
				<label>Referred by:</label>
				<select name="referrer" id="referrer" class="form-control">
					<option value="0">Select referrer name</option>
					<?php 
						foreach ($arrReferrers as $arrReferrer)
						{
							echo '<option value="'. $arrReferrer['value'] .'">'. $arrReferrer['name'] .'</option>';
						}
					?>
				</select>
				<label>Referrer Commission Rate</label>
				<div class="row">
					<div class="col-xs-6">
						<input type="text" name="referrer_cash_rate" id="referrer_cash_rate" class="form-control" placeholder="Cash rate" value="" disabled/>
					</div>
					<div class="col-xs-6">
						<input type="text" name="referrer_product_rate" id="referrer_product_rate" class="form-control" placeholder="Product rate" value="" disabled/>
					</div>
				</div>						
		    </div>
		</div>
		<br/>
		<div class="row">
			<div class="col-xs-12">
				<div id="submit-error" class="alert alert-danger hidden"></div>
				<button class="btn btn-primary col-xs-12">Save</button>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
(function($) {
	$(document).ready(function(){
		$("#scheme").on('change', function(){
			var optionSelected = $("option:selected", this);
			var rate = optionSelected.data('rate'),
			    split = optionSelected.data('split'),
				rcr = optionSelected.data('rcr'),
				rpr= optionSelected.data('rpr');
			
			$("#rate").val(rate);
			$("#split").val(split);
			$("#referrer_cash_rate").val(rcr);
			$("#referrer_product_rate").val(rpr);
		});
		
		$("input:checkbox").click(function(){
			var checked = $(this).is(':checked');
			var confirmChange;
			var targetInput = $(this).data('target');
			
			if(true == checked)
			{
				confirmChange = confirm("You are about to override scheme values.");
				if(true == confirmChange)
				{
					$("#scheme").val(0);
					$(targetInput).attr('readonly',false);
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Please select a scheme type again.");
				$(targetInput).attr('readonly', true);
			}
		});

		jQuery("#referrer").change(function(){
			var SelectedValue = jQuery(this).children("option:selected").val();
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
		else if( referrer_cash_rate < 16)
		{
			htmlError += "<li>Referrer active. Cash rate can't be lower than 16% </li>";
			intErrorCount++;
		}

		if( "" == referrer_product_rate)
		{
			htmlError += "<li>Referrer active. Product rate is required.</li>";
			intErrorCount++;
		}
		else if( referrer_product_rate < 4)
		{
			htmlError += "<li>Referrer active. Product rate can't be lower than 4%</li>";
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
endif;

wp_enqueue_script('jquery-ui-dialog');
get_footer();
?>