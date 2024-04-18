<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coach;
use Illuminate\Support\Facades\Storage;
use DB;

class CoachController extends Controller
{
public function getCoachByUserId($user_id)
{
    if (!$user_id) {
        return response()->json(['error' => 'User ID is required'], 400);
    }
    
    // Fetch coach data based on user_id
    $coach = DB::table('tbl_users')
                ->join('coaches', 'tbl_users.coach_id', '=', 'coaches.id')
                ->select('coaches.id', 'coaches.name', 'coaches.description', 'coaches.image')
                ->where('tbl_users.id', $user_id)
                ->first();

    if (!$coach) {
        return response()->json(['error' => 'Coach not found for the user'], 404);
    }

    // Get the full URL of the image
    $coach->image = 'https://securityoncalls.com/projects/brad/storage/app/public/' . $coach->image;

    return response()->json($coach);
}




}
