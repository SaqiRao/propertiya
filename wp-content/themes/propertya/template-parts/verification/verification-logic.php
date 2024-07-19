 <?php
// Email verificatioon  
// if( isset( $_GET['verification_key'] ) && $_GET['verification_key'] != "" && !is_user_logged_in()  )
// {
//     $token  = $_GET['verification_key'];
//     $token_arr  =   explode( '-propertya-uid-', $token );
//     $key    =   $token_arr[0];
//     $uid    =   $token_arr[1];
//     $token_db   =   get_user_meta( $uid, 'user_email_verification_token', true ); 
//     if( $token_db != $key )
//     {
//         echo '<script>jQuery(document).ready(function($) { toastr.error("'.__( "Invalid security token.", 'propertya' ).'", "", {timeOut: 3500,"closeButton": true, "positionClass": "toast-top-right"}); });</script>';
//     }
//     else
//     {
//         echo '<script>jQuery(document).ready(function($) { toastr.success("'.__( "Your account has been verified.", 'propertya' ).'", "", {timeOut: 3500,"closeButton": true, "positionClass": "toast-top-right"}); });</script>';
//         update_user_meta($uid, 'user_email_verification_token', '');

//     // Set the user's role (and implicitly remove the previous role).
//     $user = new WP_User( $user_id );
//     $user->set_role( 'subscriber' );
//     }
// } 