<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index()
{
    $user = auth()->user();

    if ($user->role_id == 3) {
        $reservations = Reservation::with('table')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
    } else {
        $reservations = Reservation::with('table')
            ->latest()
            ->paginate(10);
    }

    // Tables that are available
    $tables = Table::where('status', 'available')->get();

    return view('reservations.index', compact('tables', 'reservations'));
}
    

    public function create()
    {
        $tables = Table::where('status', 'available')->get();
        return view('reservations.create', compact('tables'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'table_id' => 'required|exists:tables,id',
        'guests' => 'required|integer|min:1',
        'reservation_time' => 'required|date|after:now',
    ]);

    // Store the reservation
    Reservation::create([
        'user_id' => auth()->id(),
        'table_id' => $request->table_id,
        'guests' => $request->guests,
        'reservation_time' => $request->reservation_time,
        'status' => 'Chờ xác nhận',
    ]);

    Table::where('id', $request->table_id)->update(['status' => 'occupied']);

    return redirect()->route('reservations.index')->with('success', 'Reservation successful.');
}

public function update(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);
    
    if ($request->action === 'accept') {
        $reservation->update(['status' => 'Xác nhận']);
    } elseif ($request->action === 'reject') {
        $reservation->update(['status' => 'Huỷ']);
    } else {
        $reservation->update(['status' => 'Chờ xác nhận']);
    }

    return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
}
}
