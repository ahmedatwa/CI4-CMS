<?php
return [
    // Heading
    'heading_title'     => 'Customer Activity',
	
    // Text
    'text_extension'    => 'Extensions',
    'text_edit'         => 'Edit Dashboard Recent Customer Activity',
    'text_success'      => 'Success: You have modified dashboard customer activity!',
    'text_edit'         => 'Edit Customer Activity',
    // Entry
    'entry_status'      => 'Status',
    'entry_sort_order'  => 'Sort Order',
    'entry_width'       => 'Width',
    // Column
    'column_comment'    => 'Comment',
    'column_date_added' => 'Date Added',
    // activity
    'text_activity_customer_login'           => '<a href="customer_id=%d">%s</a> logged in.',
    'text_activity_customer_register'        => '<a href="customer_id=%d">%s</a> registered a new account.',
    'text_activity_edit'                     => '<a href="customer_id=%d">%s</a> updated their account details.',
    'text_activity_password'                 => '<a href="customer_id=%d">%s</a> updated their account password.',
    'text_activity_reset'                    => '<a href="customer_id=%d">%s</a> reset their account password.',
    'text_activity_login'                    => '<a href="customer_id=d">%s</a> logged in.',
    'text_activity_forgotten'                => '<a href="customer_id=d">%s</a> has requested a reset password.',
    'text_activity_address_add'              => '<a href="customer_id=%d">%s</a> added a new address.',
    'text_activity_address_edit'             => '<a href="customer_id=%d">%s</a> updated their address.',
    'text_activity_address_delete'           => '<a href="customer_id=%d">%s</a> deleted one of their addresses.',
    'text_activity_order_account'            => '<a href="customer_id=%d">%s</a> added a <a href=>"order_id=>%d">new order</a>.',
    'text_activity_customer_balance_update'  => '<a href="customer_id=%d">name=</a> Balance updated',
    'text_activity_project_offer_selected'   => '<a href="customer_id=%d">name=</a> received a proposal for <a href="project_id=%d"><strong>project</strong></a>',
    'text_activity_project_offer_accepted'   => '<a href="customer_id=%d">name=</a> Accepted the job proposal for <a href="project_id=%d"><strong>project</strong></a>',
    'text_activity_project_bid_add'          => '<a href="customer_id=%d">name=</a> have received new bid for <a href="project_id=%d"><strong>project</strong></a>.',
    'text_activity_project_milestone_create' => '<a href="customer_id=%d">name=</a> created a Milestone for <a href="project_id=%d"><strong>project</strong></a>.',
    'text_activity_project_milestone_update' => '<a href="customer_id=%d">name=</a> Milestone status updates for <a href="project_id=%d"><strong>project</strong></a>.',
    'text_activity_customer_review'          => 'You have received new <a href="project_id=%d"><strong>project</strong></a> feedback.',
    // error
    'error' => [
        'permission' => 'Warning: You do not have permission to modify dashboard customer activity!',
    ]
];
