<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $this->validate($request,[
            'movie_name' => 'required|string',
            'movie_banner' => 'required|file|mimes:jpeg,png,jpg', // Adjust the allowed file types and size
            'director_name' => 'required|string',
            'cenema_name' => 'required|string',
            'release_date' => 'required|string',
            'details' => 'required|string',
            'duration' => 'required|string',
            'movie_type' => 'required|string',
            'location_name' => 'required|string',
        ]);
        $file = $request->file('movie_banner');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Move the file to the public/uploads folder
        $file->move(base_path('public/uploads'), $fileName);
        $validatedData['movie_banner'] = $fileName;
//         Create the movie
        $movie = Movie::create($validatedData);

        return response()->json(['message' => 'Movie created successfully', 'data' => $movie], 201);
    }
    public function remove($id){
        $movie = Movie::find($id);
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
    public function show($id)
    {
        // Find the movie by ID
        $movie = Movie::with('timeSlots', 'tickets')->find($id);

        // Check if the movie exists
        if ($movie) {
            // Access the time slots and tickets related to the movie
            $timeSlots = $movie->timeSlots;
            $tickets = $movie->tickets;

            // You can return or use the data as needed
            return response()->json([
                'movie' => $movie,
              //  'timeSlots' => $timeSlots,
                //'tickets' => $tickets,
            ]);
        } else {
            return response()->json(['message' => 'Movie not found'], 404);
        }
    }
    public function getMovies()
    {
        $movies = Movie::with('timeSlots', 'tickets')->get();

// Check if any movies exist
        if ($movies->isNotEmpty()) {
            // Iterate over each movie in the collection
            foreach ($movies as $movie) {
                // Access the time slots and tickets related to each movie
                $timeSlots = $movie->timeSlots;
                $tickets = $movie->tickets;

                // You can return or use the data as needed for each movie
                return response()->json([
                    'movies' => $movies,

                ]);
            }
        } else {
            return response()->json(['message' => 'No movies found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        // Find the movie by its ID
        $movie = Movie::find($id);
        if($movie){
            if($request->file('movie_banner')){
                $file = $request->file('movie_banner');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Move the file to the public/uploads folder
                $file->move(base_path('public/uploads'), $fileName);
                $movie->movie_banner = $fileName;
            }

            $movie->movie_name = $request->movie_name;
            $movie->director_name = $request->director_name;
            $movie->cenema_name = $request->cenema_name;
            $movie->release_date = $request->release_date;
            $movie->details = $request->details;
            $movie->duration = $request->duration;
            $movie->movie_type = $request->movie_type;
            $movie->location_name = $request->location_name;
            $movie->update();
            return response()->json(['message' => 'Movie updated successfully', 'data' => $movie], 200);
        }

        return response()->json(['message' => 'movie not found'], 404);
    }
}
