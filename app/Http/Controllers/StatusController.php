<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StatusController extends Controller
{
    public function index()
    {
        return view('admin.email');
    }
    
    
   public  function updatePaymentStatus(Request $request) {
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->input('email');

    $user = DB::table('tbl_users')->where('email', $email)->first();

    if ($user) {
        // If the user exists, update the payment status to 1
        DB::table('tbl_users')->where('email', $email)->update(['payment_status' => 1]);

        // Return a success message
         return redirect()->route('by-pass')->with('success', 'Payment Status Updated Successfully!');
    } else {
        // If the user doesn't exist, return an error message
         return redirect()->route('by-pass')->with('error', 'User Not Found!');
    }
}

public function markAllAsRead(Request $request)
{
    try {
        // Update 'seen' column for all notifications
        DB::table('admin_notifications')
            ->update(['seen' => '1']); // Update 'seen' column to '1' for all rows
        

        return redirect()->route('admin-dashboard')->with('success', 'All notifications marked as read');
    } catch (\Exception $e) {
        // Log and handle the error
        \Log::error('Error updating notifications: ' . $e->getMessage());
        return redirect()->route('admin-dashboard')->with('error', 'Failed to mark all notifications as read');
    }
}


}
