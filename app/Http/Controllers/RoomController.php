<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function showForm()
    {
        return view('booking-form');
    }

    public function bookRoom(Request $request)
    {
        $request->validate([
            'datePicked' => 'required|date_format:d/m/Y',
            'startTime' => 'required|date_format:H:i:s',
            'endTime' => 'required|date_format:H:i:s|after:startTime',
            'capacity' => 'required|integer|min:1'
        ]);

        $roomsFeatures = [
            101 => 2,
            102 => 3,
            103 => 4
        ];

        $room = new Room($roomsFeatures);
        $room->readRoomsDatabase($request->datePicked);
        $availableRooms = $room->getAvailableRooms($request->startTime, $request->endTime);
        $roomIdAssigned = $room->getOptimizedCapacityRoom($availableRooms, $request->capacity);

        if ($roomIdAssigned > 0) {
            $room->writeRoomsDatabase($request->startTime, $request->endTime, $roomIdAssigned);
            $successMessage = "Room ID $roomIdAssigned assigned on {$request->datePicked} for {$request->capacity} people and time frame {$request->startTime} - {$request->endTime}.";
            return redirect()->route('booking.form')->with('success', $successMessage);
        } else {
            $errorMessage = "Sorry, no meeting room available on {$request->datePicked} for {$request->capacity} people and time frame {$request->startTime} - {$request->endTime}.";
            return redirect()->route('booking.form')->with('error', $errorMessage);
        }
    }
}
