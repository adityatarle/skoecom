<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Get the currently logged-in user
        $orders = Order::where('user_id', $user->id)->get(); // Fetch orders for the user

        return view('profile.show', compact('user', 'orders')); // Pass the user and orders to the view
    }

    public function edit()
    {
        $user = Auth::user(); // Get the currently logged-in user
        return view('profile.edit', compact('user')); // Pass the user to the view
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Ignore current user's email
            'address' => 'nullable|string|max:255', // Example validation
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address'); // Update address
        $user->phone = $request->input('phone'); // Update phone
        // Update other user fields here
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!'); // Redirect with a success message
    }
}