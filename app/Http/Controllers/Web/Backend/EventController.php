<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $events= Event::all();
        return view('backend.layouts.events.index', compact('events'));
    }

    public function create()
    {
        return view('backend.layouts.events.create');
    }

    public function store(Request $request)
    {
        validator($request->all(), [
            'event_title' => 'required|string|max:255',
            'event_description' => 'required|string|max:255',
            'event_date' => 'required|string|max:255',
            'event_location' => 'required|string|max:255',
            'event_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('event_image')) {
            $event_image_path = $request->file('event_image')->store('event_image', 'public');
            $validatedData['event_image'] = $event_image_path;
        }

        Event::create([
            'event_title' => $request->event_title,
            'event_description' => $request->event_description,
            'event_date' => $request->event_date,
            'event_location' => $request->event_location,
            'event_image' => $event_image_path
        ]);
        return redirect()->route('event.index')->with('success', 'New event added successfully');

        //
    }
    public function edit($id){
        $event = Event::find($id);
        return view('backend.layouts.events.edit', compact('event'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_description' => 'required|string|max:255',
            'event_date' => 'required|string|max:255',
            'event_location' => 'required|string|max:255',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Upload the horse image if provided
        if ($request->hasFile('event_image')) {
            $event_image_path = $request->file('event_image')->store('event_image', 'public');
            $validatedData['event_image'] = $event_image_path;
        }
        $event = Event::find($id);
        $event->event_title = $request->event_title;
        $event->event_description = $request->event_description;
        $event->event_date = $request->event_date;
        $event->event_location = $request->event_location;
        if ($event_image_path) {
            $event->event_image = $event_image_path;
        }
        $event->save();
        return redirect()->route('event.index')->with('success', 'Event updated successfully');
    }

    public function destroy($id){
        $event = Event::find($id);
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event deleted successfully');
    }

}
