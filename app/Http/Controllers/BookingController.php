<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::all()->sortByDesc('created_at')->forPage(0, 20);
        return $bookings;
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
        $booking = new Booking();
        $booking->room_id = $request.get('room_id');
        $booking->payment_id = null;
        $booking->check_in_time = $request->get('check_in_time');
        $booking->check_out_time = $request->get('check_out_time');
        $booking->customer_id = null;
        $booking->confirmed = false;
        $booking->adult = $request->get('adult');
        $booking->children = $request->get('children');
        $booking->no_of_rooms = $request->get('no_of_rooms');

        $booking->save();

        return redirect()->action('BookingController@index')->with('status', 'Room booked successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
