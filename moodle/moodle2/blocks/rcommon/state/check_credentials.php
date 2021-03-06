<?php

// MARSUPIAL ************ AFEGIT -> New functionality to manage credentials
// 2012.06.06 @mmartinez

    require_once('../../../config.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->dirroot.'/blocks/rcommon/WebServices/Authentication/AuthenticateContent.php');
    
    $cred = optional_param('id_cr', '', PARAM_INT);
    
    $credential = $DB->get_record_sql ("SELECT b.id AS bookid, cred.euserid as userid, cred.credentials FROM {$CFG->prefix}rcommon_user_credentials cred LEFT JOIN {$CFG->prefix}rcommon_books b ON cred.isbn = b.isbn WHERE cred.id = '{$cred}'");
    
    $data = new stdClass();
    $data->bookid     = $credential->bookid;
    $data->id         = 0;
    $data->unitid     = 0;
    $data->activityid = 0;
    $data->course     = 1;
    $data->module     = 'check_credentials';
    $data->cmid       = 0;
    
    $usr_creden              = new stdClass();
    $usr_creden->credentials = $credential->credentials;
    $usr_creden->euserid     = $credential->userid;
    
    $result = AuthenticateUserContent($data, $usr_creden, false);
    
    if ($result->AutenticarUsuarioContenidoResult->Codigo == 1){
    	echo '<span style="color:green">' . get_string('good_connection', 'block_rcommon') . '</span>';
    } else {
  		echo '<span style="color:red">' . get_string('bad_connection', 'block_rcommon') . ': <span style="font-size:small">' . get_string('error_code_' . $result->AutenticarUsuarioContenidoResult->Codigo, 'block_rcommon') . '</span></span>';
    }
    
// ************** FI
?>