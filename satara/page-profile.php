<?php
/**
 * Template Name: Profile
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

$intUserid = intval( get_query_var('up_username', get_current_user_id()) );
// initialize page with the most recent payin
$intPayinId = get_recent_payinid($intUserid);

if(isset($_POST) && "" != $_POST['posttype'])
{
	switch ($_POST['posttype'])
	{
		case 'newpayin':
			// second layer validation
			$arrData = $_POST;
			$intErrorCount = 0;
			$arrProcessedData = array();
			
			foreach ($arrData as $strKey => $strData)
			{
				if("" == $strData)
				{
					++$intErrorCount;			
				}
				else
				{
					if($strKey == 'posttype' || $strKey == 'investor_name')
					{
						continue;
					}
					
					$arrProcessedData[$strKey] = intval($strData);
				}
			}
			
			if(0 < $intErrorCount)
			{
				echo '<div class="col-xs-12 alert alert-danger">Error: Values missing from new pay in form.</div>';
			}
			else
			{
				add_new_payin($arrProcessedData);
			}
			break;
		case 'payouttimeframe':
			$intPayinId = $_POST['payin_id'];
			break;
			
	}
}
// Get all active payin entry dates
$arrTimeframe = get_payout_timeframe($intUserid);
// Generate the payout data
$arrPayoutData = get_payout_data($intUserid, $intPayinId);

// Referrals
$arrReferrals = get_referrals($intUserid);

?>
<div class="container">
	<div class="col-xs-4">
	<?php 
	while (have_posts()): 
		the_post();
		the_content();
	endwhile;
	?>
	</div>
	<div class="col-xs-8">
		<div class="dashboard row">
			<div class="col-xs-3">
			<a class="btn btn-primary dashboard-btn">
		    <?php echo "P" . get_total_investment($intUserid); ?>
		    </a>
		    <h5>Investment</h5>
		    </div>
		</div>
		<div role="tabpanel">
			<!-- Nav tabs -->
		  	<ul id="account-tab" class="nav nav-tabs" role="tablist">
		    	<li role="presentation" class="active"><a href="#payout" aria-controls="payout" role="tab" data-toggle="tab">Payout History</a></li>		    			    
		    	<li role="presentation"><a href="#referrals" aria-controls="referrals" role="tab" data-toggle="tab">Referrals</a></li>
		    	<li role="presentation"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Claimed Products</a></li>
		    	<li role="presentation"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
		  	</ul>
	
	  		<!-- Tab panes -->
	  		<div class="tab-content">
	    		<div role="tabpanel" class="tab-pane fade in active" id="payout">
	    			<div class="container">
		    			<div class="admin-controls col-xs-8">
		    				<form method="post" name="payoutform">
		    					<input type="hidden" name="posttype" value="payouttimeframe" />
								<select name="payin_id" id="payin_id" class="form-control" onchange="this.form.submit()">
									<option value="0">Select Active Payout</option>
									<?php 
									foreach ($arrTimeframe as $arrOption)
									{
										echo '<option value="'.$arrOption['payin_id'].'">'. $arrOption['name'] .'</option>';
									}
									?>
								</select>
							</form>
						</div>
						<div class="admin-controls col-xs-4">					
		    				<?php if( user_can($current_user, 'edit_posts') ): ?>	    					
								<a href="<?php echo site_url('new-pay-in') . '?iid=' . $intUserid?>" class="btn btn-success col-xs-12">New Pay-in</a>
							<?php endif; ?>
						</div>
					</div>
					<div class="payout-table col-xs-12">					
			    		<table id="payout-table">
							<thead>
								<tr>										
									<th>Payout Date</th>
									<th>Amount</th>
									<th>Points</th>
									<th>Status</th>
									<th>Remarks</th>
									<?php if( user_can($current_user, 'edit_posts') ): ?>
									<th>Action</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($arrPayoutData as $objPayoutData)
								{
									$strPending = '';
									$strClaimed = '';
									
									$arrStatus = process_status($objPayoutData->status);									
									
									$strPayoutDate = process_dates((int) $objPayoutData->payout_date);
									echo '<tr class="po-'. $objPayoutData->id .'" data-class=".po-'. $objPayoutData->id .'">';									
									//echo '<td>'. str_pad($objPayoutData->payin_id, 5, 0, STR_PAD_LEFT).'-'. $objPayoutData->id . '</td>';
									echo '<td><p class="can_edit">'. $strPayoutDate .'</p><div class="edit-mode hidden"><input type="text" class="form-control payout-date" name="payout_date" value="'. $strPayoutDate .'"></div></td>';
									echo '<td>'. $objPayoutData->amount .'</td>';
									echo '<td>'. $objPayoutData->points .'</td>';
									echo '<td><p class="can_edit">'. $arrStatus['name'] .'</p>
											<div class="edit-mode hidden">
											<select class="form-control status" name="status">
												<option value="0" '. $arrStatus['pending'] .' >Pending</option>
												<option value="1" '. $arrStatus['claimed'] .' >Claimed</option>
												<option value="2" '. $arrStatus['queued'] .' >Queued</option>
											<select>
											</div>
										  </td>';
									echo '<td><p class="can_edit">'. $objPayoutData->remarks .'<p><div class="edit-mode hidden"><textarea name="remarks" class="form-control remarks">'. $objPayoutData->remarks .'</textarea></div></td>';
									
									if( user_can($current_user, 'edit_posts') ):
										echo "<td>
												<a title='Edit' class='payout-edit'>edit</a>&nbsp;												
		    									<a title='Cancel' class='payout-cancel hidden'>cancel</a>&nbsp;
												<a title='Save' class='payout-save hidden' data-id='". $objPayoutData->id ."' data-payinid='". $objPayoutData->payin_id ."'>save</a>&nbsp;
											  </td>";
									endif;
									echo "</tr>";
									
								}
								?>
							</tbody>
						</table>
					</div>
	    		</div>	    		   		
	    		<div role="tabpanel" class="tab-pane fade" id="referrals">
	    			<div class="referral-table col-xs-12">					
			    		<table id="referral-table">
							<thead>
								<tr>
									<th>Control #</th>										
									<th>Referree</th>
									<th>Cash</th>
									<th>Status</th>
									<th>Product</th>
									<th>Status</th>
									<th>Release Date</th>
									<?php if( user_can($current_user, 'edit_posts') ): ?>
									<th>Action</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
							<?php 
							foreach ($arrReferrals as $objReferral)
							{
								$strReferralId = "RC-" . str_pad($objReferral->id, 5, 0, STR_PAD_LEFT);
								$objReferree = get_user_by('id', (int) $objReferral->referree);
								$strReleaseDate = process_dates($objReferral->release_date);
								$arrCashStatus = process_status($objReferral->cash_commission_status);
								$arrProductStatus = process_status($objReferral->product_commission_status);
								
								echo '<tr>';
								echo '<td>';
								echo '<p>'. $strReferralId .'</p>';
								echo '</td>';								
								echo '<td>';
								echo '<p>'. $objReferree->display_name .'</p>';
								echo '</td>';
								echo '<td>';
								echo '<p>'. $objReferral->cash_commission .'</p>';
								echo '</td>';
								echo '<td>';
								echo '<p>'. $arrCashStatus['name'] .'</p>';
								echo '</td>';
								echo '<td>';
								echo '<p>'. $objReferral->product_commission .'</p>';
								echo '</td>';
								echo '<td>';
								echo '<p>'. $arrProductStatus['name'] .'</p>';
								echo '</td>';
								echo '<td>';
								echo '<p>'. $strReleaseDate .'</p>';
								echo '<div class="edit-mode hidden"><input type="text" name="release_date" value="'. $strReleaseDate .'"></div>';
								echo '</td>';
								if( user_can($current_user, 'edit_posts') ):
								echo "<td>
										<a title='Edit' class='referral-edit'>edit</a>&nbsp;
		    							<a title='Cancel' class='glyphicon glyphicon-ban-circle referral-cancel'></a>&nbsp;
										<a title='Save' class='glyphicon glyphicon-floppy-disk referral-save disable-save'></a>&nbsp;
									  </td>";
								endif;
								echo '</tr>';
							}
							?>
							</tbody>
						</table>
					</div>
	    		</div>
	    		<div role="tabpanel" class="tab-pane fade" id="products"></div>
	    		<div role="tabpanel" class="tab-pane fade" id="documents"></div>
	  		</div>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#payout-table, #referral-table").DataTable({
		"sDom": '<"top">rt<"bottom"flp><"clear">',
		"paging" : false,
		"searching" : false
	});
	jQuery("#payin_id").val(<?php echo $intPayinId;?>);
	jQuery(".payout-date").datepicker({dateFormat: 'MM-dd-yy'});
	
	jQuery(".paginate_button").on("click", function(){
		jQuery(".payout-date").datepicker({dateFormat: 'MM-dd-yy'});
	});
});

jQuery(".payout-edit").on('click', function(){
	var contentRow = jQuery(this).parent().parent().data('class');
	jQuery(contentRow + " div.edit-mode").removeClass('hidden');
	jQuery(contentRow + " p.can_edit").addClass('hidden');
	jQuery(contentRow + " .payout-save").removeClass("hidden");
	jQuery(contentRow + " .payout-cancel").removeClass("hidden");	
	jQuery(this).addClass("hidden");
});
	
jQuery(".payout-cancel").on('click', function(){
	var contentRow = jQuery(this).parent().parent().data('class');
	jQuery(contentRow + " div.edit-mode").addClass('hidden');
	jQuery(contentRow + " p").removeClass('hidden');
	jQuery(contentRow + " .payout-save").addClass('hidden');
	jQuery(this).addClass("hidden");
	jQuery(contentRow + " .payout-edit").removeClass("hidden");
});
	
jQuery(".payout-save").on('click', function(){
	var contentRow = jQuery(this).parent().parent().data('class');
	var j_payout_date = jQuery(contentRow + " .payout-date").val();
	var j_status = jQuery(contentRow + " .status option:selected").val();
	var j_remarks = jQuery(contentRow + " .remarks").val();
	var j_id = jQuery(this).data("id");
	var j_payin_id = jQuery(this).data("payinid");
	
	jQuery.ajax({
		type: "POST",
		url: "<?php echo admin_url('admin-ajax.php')?>",
		data: {
			action: "update_payout",
			payout_date : j_payout_date,
			status : j_status,
			remarks : j_remarks,
			id : j_id,
			payin_id : j_payin_id
		},
		success: function(result)
		{
			var objResult = jQuery.parseJSON(result);
			alert(objResult.message);
			
			if(objResult.success !== false)
			{
				location.reload();
			}
		}
	});
	
	jQuery(this).addClass('hidden');
	jQuery(contentRow + " .payout-edit").removeClass('hidden');
	jQuery(contentRow + " .payout-cancel").addClass('hidden');
	
});

jQuery(".referral-edit").on('click', function(){
	var contentRow = jQuery(this).parent().parent().data('class');
	jQuery(contentRow + " div.edit-mode").removeClass('hidden');
	jQuery(contentRow + " p.can_edit").addClass('hidden');
	jQuery(contentRow + " .referral-save").removeClass('disable-save');
});
	
jQuery(".referral-cancel").on('click', function(){
	var contentRow = jQuery(this).parent().parent().data('class');
	jQuery(contentRow + " div.edit-mode").addClass('hidden');
	jQuery(contentRow + " p").removeClass('hidden');
	jQuery(contentRow + " .referral-save").addClass('disable-save');
});

</script>

<?php

wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('datatables', '//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js', array('jquery'));
wp_enqueue_style('datatables-css', '//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css');
get_footer();
?>