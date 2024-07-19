<?php
if(isset($_GET['page-type']) && $_GET['page-type'] !="")
{
	$page_type  = $_GET['page-type'];
	$user_id = get_current_user_id();
	if($page_type == 'dashboard')
	{
		get_template_part( 'template-parts/dashboard/content-area/dashboard');
	}
	else if($page_type == 'my-profile')
	{
		if(get_user_meta($user_id, 'user_role_type', true) == 'agency')
		{
			get_template_part( 'template-parts/dashboard/profile/agency');
		}
		if(get_user_meta($user_id, 'user_role_type', true) == 'agent')
		{
			get_template_part( 'template-parts/dashboard/profile/agent');
		}
		if(get_user_meta($user_id, 'user_role_type', true) == 'buyer')
		{
			get_template_part( 'template-parts/dashboard/profile/buyer');
		}
	}
	else if($page_type == 'order-complete')
	{
		get_template_part( 'template-parts/dashboard/my-properties/order');
	}
	else if($page_type == 'submit-property')
	{
		get_template_part( 'template-parts/dashboard/my-properties/create');
	}
	else if($page_type == 'publish')
	{
		get_template_part( 'template-parts/dashboard/my-properties/publish');
	}
	else if($page_type == 'pending')
	{
		get_template_part( 'template-parts/dashboard/my-properties/pending');
	}
	else if($page_type == 'featured')
	{
		get_template_part( 'template-parts/dashboard/my-properties/featured');
	}
	else if($page_type == 'expired')
	{
		get_template_part( 'template-parts/dashboard/my-properties/expired');
	}
	else if($page_type == 'add-agents')
	{
		get_template_part( 'template-parts/dashboard/agents/create');
	}
	else if($page_type == 'edit-agents')
	{
		get_template_part( 'template-parts/dashboard/agents/view-agent');
	}else if($page_type == 'edit-listing')
	{
		get_template_part( 'template-parts/dashboard/agents/edit');
	}
	else if($page_type == 'view-all-agents')
	{
		get_template_part( 'template-parts/dashboard/agents/publish');
	}
	else if($page_type == 'received-reviews')
	{
		get_template_part( 'template-parts/dashboard/reviews/received');
	}
	else if($page_type == 'submitted-reviews')
	{
		get_template_part( 'template-parts/dashboard/reviews/submitted');
	}
	else if($page_type == 'profile-received-reviews')
	{
		get_template_part( 'template-parts/dashboard/profile-reviews/received');
	}
	else if($page_type == 'profile-submitted-reviews')
	{
		get_template_part( 'template-parts/dashboard/profile-reviews/submitted');
	}
	else if($page_type == 'favourites')
	{
		get_template_part( 'template-parts/dashboard/my-properties/favourites');
	}
	else if($page_type == 'invoices')
	{
		get_template_part( 'template-parts/dashboard/invoices/invoice');
	}
	else if($page_type == 'process-payemnts')
	{
		get_template_part( 'template-parts/dashboard/my-properties/complete');
	}
	else
	{
		get_template_part( 'template-parts/dashboard/content-area/dashboard');
	}
}
else
{
	get_template_part( 'template-parts/dashboard/content-area/dashboard');
}