<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request data
       $timeSlotData =  $this->validate($request,[
            'movie_id' => 'required|exists:movies,id',
            'movie_date' => 'required',
            'time_slot' => 'required',
            'total_seat' => 'required|integer|min:1',
            'premium_seat_available' => 'required|integer|min:0',
            'general_seat_available' => 'required|integer|min:0',
            'ticket_type' => 'required',
        ]);

        $totalSeat = $request->total_seat;
        $premiumSeat = $request->premium_seat_available;
        $generalSeat = $request->general_seat_available;
        if($totalSeat > 50){
            return response()->json(['error' => 'Total Seat not greater than 50.'], 422);
        }
        elseif ($premiumSeat + $generalSeat > $totalSeat) {
            return response()->json(['error' => 'The sum of premium and general seats cannot exceed total seats.'], 422);
        }elseif ($premiumSeat + $generalSeat < $totalSeat) {
            return response()->json(['error' => 'The sum of premium and general seats cannot less than total seats.'], 422);
        }

        // If the check passes, create the time slot
        $timeSlot = TimeSlot::create($timeSlotData);

        // Your additional logic goes here...

        return response()->json(['data' => $timeSlot], 201);
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $timeSlotData =  $this->validate($request,[
            'movie_id' => 'exists:movies,id',
            'movie_date' => '',
            'time_slot' => '',
            'total_seat' => 'integer|min:1',
            'premium_seat_available' => 'integer|min:0',
            'general_seat_available' => 'integer|min:0',
            'ticket_type' => '',
        ]);
        // Find the movie by its ID
        $timeslot = TimeSlot::find($id);
        if($timeslot){
            $totalSeat = $timeSlotData['total_seat'];
            $premiumSeat =  $timeSlotData['premium_seat_available'];
            $generalSeat =  $timeSlotData['general_seat_available'];
            if($totalSeat > 50){
                return response()->json(['error' => 'Total Seat not greater than 50.'], 422);
            }
            elseif ($premiumSeat + $generalSeat > $totalSeat) {
                return response()->json(['error' => 'The sum of premium and general seats cannot exceed total seats.'], 422);
            } elseif ($premiumSeat + $generalSeat < $totalSeat) {
                return response()->json(['error' => 'The sum of premium and general seats cannot less than total seats.'], 422);
            }
            // Update the movie with the validated data
            $timeslot->update($timeSlotData);

            return response()->json(['message' => 'TimeSlot updated successfully', 'data' => $timeslot], 200);
        }
        return response()->json(['message' => 'timeslot not found'], 404);
    }
    public function show($id)
    {
        // Find the movie by ID
        $movie = Movie::with('timeSlots')->find($id);

        // Check if the movie exists
        if ($movie) {
            // Access the time slots and tickets related to the movie
            $timeSlots = $movie->timeSlots;
            $tickets = $movie->tickets;

            // You can return or use the data as needed
            return response()->json([
                'timeSlots' => $timeSlots,
            ]);
        } else {
            return response()->json(['message' => 'TimeSlot not found'], 404);
        }
    }
    public function singleSlotbyId($id)
    {
        // Find the movie by ID
        $timeSlot = TimeSlot::find($id);

        if ($timeSlot) {
            return response()->json([
                'timeSlot' => $timeSlot,
                200
            ]);
        } else {
            return response()->json(['message' => 'TimeSlot not found'], 404);
        }
    }
}
