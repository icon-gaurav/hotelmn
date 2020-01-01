<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all()->sortByDesc('updated_at');
        return $rooms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new Room();
        $room->name = $request->get('name');
        $room->total_count = $request->get('total_count');
        $room->booked_count = $request->get('booked_count');
        $room->price_per_night = $request->get('price_per_night');
        $room->discount = $request->get('discount');
        $room->area = $request->get('area');
        $room->adult_guest_limit = $request->get('adult_guest_limit');
        $room->children_guest_limit = $request->get('children_guest_limit');
        $room->facilities = $request->get('facilities');
        $room->wifi = $request->get('wifi');
        $room->special = $request->get('special');
        $room->images = $request->get('images');
        $room->save();

        return redirect()->action('RoomController@index')->with('status', 'Room added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return $room;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->name = $request->get('name');
        $room->total_count = $request->get('total_count');
        $room->booked_count = $request->get('booked_count');
        $room->price_per_night = $request->get('price_per_night');
        $room->discount = $request->get('discount');
        $room->area = $request->get('area');
        $room->adult_guest_limit = $request->get('adult_guest_limit');
        $room->children_guest_limit = $request->get('children_guest_limit');
        $room->facilities = $request->get('facilities');
        $room->wifi = $request->get('wifi');
        $room->special = $request->get('special');
        $room->images = $request->get('images');

        $room->save();
        return redirect()->action('RoomController@index')->with('status', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Room::destroy($id);
        return redirect()->action('RoomController@index')->with('status', $count.' room deleted successfully!');
    }
}
