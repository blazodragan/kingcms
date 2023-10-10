<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PhotoController extends Controller
{
    /**
     * Delete the current user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Request $request, Ticket $ticket)
    {
        $ticket->deletePhoto();
        return back(303)->with('status', 'photo-deleted');
    }
}
