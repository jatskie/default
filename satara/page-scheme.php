<?php
/**
 * Template Name: Schemes
 *
 * This is the template that displays New Pay In form
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */
if(is_user_logged_in() == false || false == user_can($current_user, 'edit_posts'))
{
	wp_safe_redirect(site_url());
}

get_header();

if(isset($_POST) && $_POST['posttype'] != "")
{
	$arrData = $_POST;
	switch ($arrData['posttype'])
	{
		case 'edit':			
			$boolResult = update_payin_scheme($arrData);
			if(false == $boolResult)
			{
				echo '<div class="container"><div class="col-xs-12 alert alert-danger">Error: Update unsuccessful.</div></div>';
			}
			else
			{
				echo '<div class="container"><div class="col-xs-12 alert alert-success">Updated successfully.</div></div>';
			}
			break;
		case 'add':
			$boolResult = add_payin_schemes($arrData);
			if(false == $boolResult)
			{
				echo '<div class="container"><div class="col-xs-12 alert alert-danger">Error: Add unsuccessful.</div></div>';
			}
			else
			{
				echo '<div class="container"><div class="col-xs-12 alert alert-success">Added successfully.</div></div>';
			}
			break;
	}
}

$arrSchemes = get_payin_schemes(true);

$arrCurrentScheme = array();
$arrCurrentSchemes = get_payin_schemes(false);

foreach ($arrCurrentSchemes as $scheme)
{
	$arrCurrentScheme = $scheme;
}

?>
<div class="scheme-container">
	<form method="post" onsubmit="return validateForm()">
		<input type="hidden" name="posttype" id="posttype" value="" />
		<select name="id" id="scheme_id">
			<option value="0">Select scheme to edit</option>
			<?php 
			foreach ($arrSchemes as $arrScheme)
			{
				$arrUserData = get_user_by('ID', $arrScheme['created_by']);

				echo '<option 
 							value="'.$arrScheme['value'].'"
 							data-rate="'. $arrScheme['rate'] .'"
 							data-split="'. $arrScheme['split'] .'"
 							data-points="'. $arrScheme['points'] .'"
 							data-description = "'. $arrScheme['description'] .'"
 							data-rcr="'. $arrScheme['referrer_cash_rate'] .'"
 							data-rpr="'. $arrScheme['referrer_product_rate'] .'"
 							data-status="'. $arrScheme['is_active'] .'"
							data-creator="'. $arrScheme['created_by'] .'"
							data-created="'. $arrScheme['date_created'] .'"
							data-modified="'. $arrScheme['modifed_by'] .'"
							data-modifiedon="'. $arrScheme['date_modified'] .'"
 					  >'. $arrScheme['description'] . ' ('. $arrScheme['name'].')</option>';
			}
			?>
		</select>
		<p>&nbsp;</p>
		<h3>Investment Rates</h3>
		<div class="row">
			<div class="col-xs-12">
				<label>Scheme Name</label>
				<input type="text" name="description" id="description" class="form-control" value="<?php echo $arrCurrentScheme['description']?>">
			</div>		

			<div class="col-xs-4">
				<label>Rate (%)</label>
				<input type="text" name ="rate" id="rate" class="form-control" value="<?php echo $arrCurrentScheme['rate']?>"/>
			</div>
			<div class="col-xs-4">
				<label>Split</label>
				<input type="text" name ="split" id="split" class="form-control" value="<?php echo $arrCurrentScheme['split']?>"/>
			</div>
			<div class="col-xs-4">
				<label>Points</label>
				<input type="text" name ="points" id="points" class="form-control" value="<?php echo $arrCurrentScheme['points']?>"/>
			</div>
		</div>		
		<p>&nbsp;</p>
		<h3>Referrer Commision Rates</h3>
		<div class="row">
			<div class="col-xs-6">
				<label>Cash</label>
				<input type="text" name ="referrer_cash_rate" id="referrer_cash_rate" class="form-control" value="<?php echo $arrCurrentScheme['referrer_cash_rate']?>"/>
			</div>
			<div class="col-xs-6">
				<label>Product</label>
				<input type="text" name ="referrer_product_rate" id="referrer_product_rate" class="form-control" value="<?php echo $arrCurrentScheme['referrer_product_rate']?>"/>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="col-xs-6">							
				<input type="hidden" name="is_active" id="is_active" value="1"/>			
		</div>		
		<div class="row">
			<p>&nbsp;</p>
			<div id="errorMsg" class="col-xs-12 alert alert-danger hidden"></div>
		</div>
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-xs-12">
				<div class="infobox pull-left"></div>				
				<button type="submit" class="btn btn-primary col-xs-2 pull-right">Save</button>
				<button type="reset" class="btn btn-danger col-xs-2 pull-right" id="cancel">Cancel</button>
				<button type="button" class="btn btn-success col-xs-2 pull-right" id="add-new">Add New</button>
			</div>
		</div>
		
	</form>
</div>
<script type="text/javascript">

	jQuery("#scheme_id").val(<?php echo $arrCurrentScheme['value'] ?>);
	
	jQuery("#scheme_id").on('change', function(){
		var SelectedScheme = jQuery(this).children("option:selected");
		if(SelectedScheme.val() > 0)
		{
			var rate = SelectedScheme.data('rate'),
				split = SelectedScheme.data('split'),
				points = SelectedScheme.data('points'),
				description = SelectedScheme.data('description'),
				rcr = SelectedScheme.data('rcr'),
				rpr = SelectedScheme.data('rpr'),
				status = SelectedScheme.data('status'),
				creator = SelectedScheme.data('creator'),
				created = SelectedScheme.data('created'),
				modified = SelectedScheme.data('modified'),
				modifiedon = SelectedScheme.data('modifiedon');

			jQuery("#rate").val(rate);
			jQuery("#split").val(split);
			jQuery("#points").val(points);
			jQuery("#description").val(description);
			jQuery("#referrer_cash_rate").val(rcr);
			jQuery("#referrer_product_rate").val(rpr);
			if(status == 1)
			{
				jQuery("#is_active_chk").attr('checked', true);
				jQuery("#is_active").val(1);
			}
			else
			{
				jQuery("#is_active_chk").attr('checked', false);
				jQuery("#is_active").val(0);
			}
			jQuery("#posttype").val('edit');
			jQuery(".infobox").html("<i><small>Created by: "+creator+" on " +created+ "</small></i>");

			jQuery("input, textarea").attr("disabled", false);
		}
		else
		{
			jQuery("#rate").val('');
			jQuery("#split").val('');
			jQuery("#points").val('');
			jQuery("#description").val('');
			jQuery("#referrer_cash_rate").val('');
			jQuery("#referrer_product_rate").val('');
			jQuery("#is_active_chk").attr('checked', false);
			jQuery("#is_active").val('');
			jQuery("#posttype").val('');

			jQuery("input, textarea").attr("disabled", true);
		}
	});

	jQuery("#add-new").on('click', function(){
		jQuery("#rate").val('');
		jQuery("#split").val('');
		jQuery("#points").val('');
		jQuery("#description").val('');
		jQuery("#referrer_cash_rate").val('');
		jQuery("#referrer_product_rate").val('');
		jQuery("#is_active_chk").attr('checked', false);
		jQuery("#is_active").val('0');
		jQuery("#posttype").val('add');
		jQuery("input, textarea").attr("disabled", false);
		jQuery("#description").focus();
		
	});

	jQuery("#cancel").on('click', function(){
		jQuery("input, textarea").attr("disabled", true);
	});

	function validateForm()
	{
		var rate = jQuery("#rate").val();
		var split = jQuery("#split").val();
		var points = jQuery("#points").val();
		var description = jQuery("#description").val();
		var rcr = jQuery("#referrer_cash_rate").val();
		var rpr = jQuery("#referrer_product_rate").val();

		var errorHtml = "<ul>";
		var intErrorCount = 0;

		if("" == rate)
		{
			errorHtml += "<li>Rate is a required field</li>";
			intErrorCount++;
		}

		if("" ==  split)
		{
			errorHtml += "<li>Split is a required field</li>";
			intErrorCount++;
		}

		if("" == points)
		{
			errorHtml += "<li>Points is a required field</li>";
			intErrorCount++;
		}

		if("" == rcr)
		{
			errorHtml += "<li>Cash rate for referrer is a required field</li>";
			intErrorCount++;
		}

		if("" == rpr)
		{
			errorHtml += "<li>Product rate for referrer is a required field</li>";
			intErrorCount++;
		}

		errorHtml += "</ul>";

		if(intErrorCount > 0)
		{
			jQuery("#errorMsg").html(errorHtml).removeClass('hidden');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
<?php 
get_footer();
?>