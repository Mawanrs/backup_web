<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::all();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.create');
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        $bookings = Booking::find(request('ids'));

        foreach ($bookings as $booking) {
            $booking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showForm()
    {
        return view('layouts.booking-form');
    }

    public function bookRoom(Request $request)
    {
        $validated = $request->validate([
            'datePicked' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
            'capacity' => 'required|integer|min:2|max:25',
        ]);

        $rooms = new Room();
        $rooms->readRoomsDatabase($request->input('datePicked'));
        $roomsOk = $rooms->getAvailableRooms($request->input('startTime'), $request->input('endTime'));
        $roomIdAssigned = $rooms->getOptimizedCapacityRoom($roomsOk, $request->input('capacity'));

        if ($roomIdAssigned > 0) {
            $rooms->writeRoomsDatabase($request->input('startTime'), $request->input('endTime'), $roomIdAssigned);
            $message = '<b>Room ID ' . $roomIdAssigned . '</b> assigned on <b>' . $request->input('datePicked') . '</b> for <b>' . $request->input('capacity') . ' people</b> and time frame <b>' . $request->input('startTime') . 'h - ' . $request->input('endTime') . 'h</b>.';
            return redirect()->back()->with('success', $message);
        } else {
            $message = 'Sorry, no meeting room available on <b>' . $request->input('datePicked') . '</b> for <b>' . $request->input('capacity') . ' people</b> and time frame <b>' . $request->input('startTime') . 'h - ' . $request->input('endTime') . 'h</b>.';
            return redirect()->back()->with('error', $message);
        }
    }
}
