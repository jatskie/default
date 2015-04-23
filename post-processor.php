<?php
require_once('../../../wp-blog-header.php');

if(is_user_logged_in() == false || false == user_can($current_user, 'edit_posts'))
{
	wp_safe_redirect(site_url());
}

if(isset($_POST) && "newpayin" == $_POST['posttype'])
{		
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
	
	$profile_url = $userpro->permalink((int)$arrData['userid']);
				
	if(0 < $intErrorCount)
	{
		wp_safe_redirect($profile_url . "?msg=1");
	}
	else
	{
		$intResultMessage = add_new_payin($arrProcessedData);
		wp_safe_redirect($profile_url . "?msg=" . $strResultMessage);
	}
}
else if(isset($_POST) && "newclaim" == $_POST['posttype'])
{
	$arrData = $_POST;
	$intErrorCount = 0;
	
	unset($arrData['posttype']);
	$arrData['date_claimed'] = time();
	
	$profile_url = $userpro->permalink((int)$arrData['userid']);
	
	$boolResult = add_claim($arrData);

	if($boolResult)
	{
		$strResultMessage = 3;
	}
	else
	{
		$strResultMessage = 2;
	}
	
	wp_safe_redirect($profile_url . "?msg=" . $strResultMessage);
}