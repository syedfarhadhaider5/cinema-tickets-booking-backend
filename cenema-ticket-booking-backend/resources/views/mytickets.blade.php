<!-- mytickets.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookme Tickets</title>
    <style>
        .booking-info {
            width: 100%;
            overflow: hidden;
        }
        .booking-info > div {
            display: inline-block;
            width: 40%; /* Adjust the width as needed */
            box-sizing: border-box;
            margin-left: 60px;
            margin-top: 3px;
            
        }
        .booking-info > div:nth-child(2) {
            width: 40%; /* Adjust the width as needed */
        }
        
    </style>
</head>
<body>

    <h1 style="text-align: center">Bookme</h1>

    @if($ticketWithUser)
        <div style="padding: 10px; border: .1px solid #0866ff">
            <h3 style="text-align: center; color: #0866ff">{{$ticketWithUser->movie->movie_name}}</h3>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Name<b/></div>
                <div><b>{{ $ticketWithUser->user->name }}<b/></div>
            </div>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Email<b/></div>
                <div><b>{{ $ticketWithUser->user->email }}<b/></div>
            </div>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Booking Date<b/></div>
                <div><b>{{ $ticketWithUser->booking_date }}<b/></div>
            </div>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Seat Number<b/></div>
                <div><b>{{ $ticketWithUser->seat_number }}<b/></div>
            </div>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Cinema<b/></div>
                <div><b>{{ $ticketWithUser->movie->cenema_name }}<b/></div>
            </div>
            <div class="booking-info" style="display: flex; justify-content: space-between; color: #656565;">
                <div><b>Time<b/></div>
                <div><b>{{ $ticketWithUser->timeSlot->time_slot }}<b/></div>
            </div>
        </div>
    @else
        <p>User not found with associated tickets.</p>
    @endif

</body>
</html>
