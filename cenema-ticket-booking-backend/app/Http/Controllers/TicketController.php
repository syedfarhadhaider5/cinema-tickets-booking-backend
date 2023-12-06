<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TimeSlot;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'movie_id' => 'required|exists:movies,id',
            'time_slot_id' => 'required|exists:time_slot,id',
            'user_id' => 'required|exists:users,id',
            'seat_number' => 'required|string',
            'cnic' => 'required|string',
            'sir_name' => 'required|string',
            'full_name' => 'required|string',
            'contact_number' => 'required|string',
            'contact_email' => 'required|email',
            'booking_date' => 'required|date',
        ]);
        $timeSlot = TimeSlot::find($validatedData['time_slot_id']);

        $seatNumber = explode(',', $validatedData['seat_number']);
        foreach ($seatNumber as $item) {
            $validatedData['seat_number'] = $item;
            $ticket = Ticket::create($validatedData);
            if ($timeSlot) {
                if ($request->ticket_type === 'premium') {
                    $timeSlot->decrement('premium_seat_available');
                } elseif ($request->ticket_type === 'general') {
                    $timeSlot->decrement('general_seat_available');
                } else {
                    return response()->json(['message' => 'Something went wrong'], 404);
                }
                $timeSlot->update();
            }
        }
        return response()->json(['message' => 'Ticket created successfully', 'ticket' => $ticket], 201);
    }
    public function remove($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->delete();
            return response()->json(['message' => 'Ticket deleted successfully'], 200);
        }
        return response()->json(['message' => 'Ticket not found'], 200);
    }
    public function getUserTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticketWithUser = Ticket::with('user', 'movie', 'timeSlot')->find($ticket->id);
            if ($ticketWithUser) {

                $pdf = pdf::loadView('mytickets', ['ticketWithUser' => $ticketWithUser]);


                // Stream the PDF to the browser
                return $pdf->stream('example.pdf');

            } else {
                return response()->json(['message' => 'There is no tickets'], 404);
            }
        } else {
            return response()->json(['message' => 'No ticket found'], 404);
        }
    }
    public function getUserTickets($id)
    {
        $user = User::find($id);
        if ($user) {
            $userTickets = User::with([
                'tickets' => function ($query) {
                    $query->orderBy('booking_date', 'asc'); // Change 'asc' to 'desc' if you want descending order
                },
                'tickets.movie'
            ])->find($user->id);
            if ($userTickets) {
                return response()->json(['userTickets' => $userTickets], 200);
            } else {
                return response()->json(['message' => 'User not found with associated tickets'], 404);
            }
        } else {
            return response()->json(['message' => 'No user found'], 404);
        }
    }
}
