<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Coach;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::all();
        return view('admin.coach.index', compact('coaches'));
    }

    public function add_coach()
    {
       
        return view('admin.coach.add');
    }

       public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string|max:110',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);
    
        // Create a new Coach instance
        $coach = new Coach();
        $coach->name = $request->name;
        $coach->description = $request->description;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('coach_images', 'public'); // Store the image in the storage folder
            $coach->image = $imagePath; // Save the file path to the image attribute
        }
    
        // Save the Coach instance to the database
        $coach->save();
    
        // Redirect back to the coaches index page
        return redirect()->route('coach.index')->with('success', 'Coach created successfully.');
    }
     public function edit($id)
    {
        $coach = Coach::findOrFail($id);
        return view('admin.coach.edit', compact('coach'));
    }

    public function update(Request $request, $id)
    {
        $coach = Coach::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:110',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coach->name = $request->name;
        $coach->description = $request->description;

        if ($request->hasFile('image')) {
            // Handle image upload
            $imagePath = $request->file('image')->store('coach_images', 'public');
            $coach->image = $imagePath;
        }

        $coach->save();

        return redirect()->route('coach.index')->with('success', 'Coach updated successfully.');
    }

    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->delete();
        return redirect()->route('coach.index')->with('success', 'Coach deleted successfully.');
    }
    
  public function assign($id)
{
    $user = DB::table('tbl_users')->find($id); // Fetch the user from tbl_users
    $coaches = Coach::all(); // Fetch all coaches
    return view('admin.coach.assign', compact('user', 'coaches')); // Pass $user and $coaches to the view
}
    
    public function updateCoach(Request $request, $id)
        {
            // Find the user by ID
            $user = DB::table('tbl_users')->where('id', $id)->first();
        
            if (!$user) {
                // Handle case where user is not found
                return redirect()->route('professional')->with('error', 'User not found.');
            }
        
            // Update the coach_id field
            DB::table('tbl_users')->where('id', $id)->update(['coach_id' => $request->coach_id]);
        
            return redirect()->route('professional')->with('success', 'Coach assigned successfully.');
        }
}

