<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class ApiGroupController extends Controller
{
    public function createGroup(Request $request)
    {
        $group = Group::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        $group->members()->attach(auth()->id()); // Add creator as a member

        return response()->json(['group' => $group]);
    }

    public function addMember(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
        $group->members()->attach($request->user_id);

        return response()->json(['message' => 'User added to group']);
    }
}
