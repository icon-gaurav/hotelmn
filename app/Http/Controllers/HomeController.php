<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Room;
use \App\Customer;
use \App\Booking;
use \App\BookedItem;
use \App\Payment;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return view('home');
        return 'This is the home page';
    }

    public function allRooms()
    {
        $rooms = Room::all()->sortByDesc('price');
        return $rooms;
    }

    public function getRoom($id)
    {
        $room = Room::findOrFail($id);
        return $room;
    }

    public function checkout(Request $request)
    {
        $customer = new Customer();
        $customer->title = $request->get('title');
        $customer->fname = $request->get('fname');
        $customer->lname = $request->get('lname');
        $customer->email = $request->get('email');
        $customer->phone = $request->get('phone');
        $customer->country = $request->get('country');
        $customer->request = $request->get('request');
        $customer->save();

        $booking = new Booking();
        $booking->payment_id = null;
        $booking->customer_id = $customer->id;

        $booking->save();

        $items = $request->get('items');
        foreach ($items as $item) {
            $book_item = new BookedItem();
            $book_item->room_id = $item['room_id'];
            $book_item->adult = $item['adult'];
            $book_item->children = $item['children'];
            $book_item->check_in_time = $item['check_in_time'];
            $book_item->check_out_time = $item['check_out_time'];
            $book_item->customer_id = $customer->id;
            $book_item->booking_id = $booking->id;
            $book_item->quantity = $item['quantity'];
            $book_item->save();
        }
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url'));
        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => "HOTEL BOOKING",
                "amount" => "3499",
                "send_email" => true,
                "email" => "icon.gaurav806@gmail.com",
                "redirect_url" => env('APP_URL') . "payment_response"
            ));


            $booking->gtw_txn_id = $response['id'];
            $booking->customer_id = $customer->id;

            $booking->save();
            return Redirect::to($response['longurl']);
        } catch (Exception $exception) {
            return 'Error: ' . $exception->getMessage();
        }
    }

    public function checkpayment(Request $request)
    {
        $payment_req_id = $request->query('payment_request_id');
        $payment_status = $request->query('payment_status');
        $payment_id = $request->query('payment_id');

        $booking = Booking::where('gtw_txn_id', $payment_req_id)->get();
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url'));
        try {
            $response = $api->paymentRequestPaymentStatus($booking->gtw_txn_id, $payment_id);
            if ($payment_status == 'Credit') {

                $payment = new Payment();
                $payment->txn_id = $response['payment']['payment_id'];
                $payment->amount = $response['payment']['amount'];
                $payment->cur = $response['payment']['currency'];
                $payment->taxes = $response['payment']['fees'];
                $payment->booking_id = $booking->id;
                $payment->customer_id = $booking->customer->id;
                $payment->save();
                return "Thanks for your payment";
            } else {
                return "Payment failed";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
