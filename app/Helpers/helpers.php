<?php

// use Carbon\Carbon;

use App\Models\ActivityLog;

/**
 * Write code on Method
 *
 * @return response()
 */
// if (! function_exists('convertYmdToMdy')) {
//     function convertYmdToMdy($date)
//     {
//         return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
//     }
// }

/**
 * Write code on Method
 *
 * @return response()
 */
// if (! function_exists('convertMdyToYmd')) {
//     function convertMdyToYmd($date)
//     {
//         return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
//     }
// }

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('activity_log')) {
    function activity_log($activity, $additional_details = '')
    {
        switch (strtoupper($activity)) {
            case 'ADDQR':
                $activity_msg = 'Added QR: '.$additional_details;
                break;
            case 'DELETEQR':
                $activity_msg = 'Deleted QR: '.$additional_details;
                break;
            case 'PRINTQR':
                $activity_msg = 'Printed QR: '.$additional_details;
                break;
            case 'DOWNLOADQR':
                $activity_msg = 'Download QR: '.$additional_details;
                break;
            case 'CHANGEPASS':
                $activity_msg = 'Changed Password';
                break;
            case 'RESETPASS':
                $activity_msg = 'Reset Password';
                break;
            case 'LOGIN':
                $activity_msg = 'Login';
                break;
            case 'LOGOUT':
                $activity_msg = 'Logout';
                break;
            
            default:
                $activity_msg = $activity;
                break;
        }

        if(Auth::check()){
            $user = auth()->user()->name;
        }else{
            $user = 'Nobody';
        }
        ActivityLog::create([
            'message' => $activity_msg,
            'user' => $user,
        ]);
    }
}