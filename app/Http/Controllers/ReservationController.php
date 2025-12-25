<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Reservation::with(['table', 'user']);

        if ($user->role_id == 3) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('table_number')) {
            $query->whereHas('table', function ($q) use ($request) {
                $q->where('table_number', 'like', '%' . $request->input('table_number') . '%');
            });
        }

        if ($request->filled('customer')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->input('customer') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('customer') . '%');
            });
        }

        $sort = $request->input('sort');
        if ($sort === 'time_asc') {
            $query->orderBy('reservation_time', 'asc');
        } elseif ($sort === 'time_desc') {
            $query->orderBy('reservation_time', 'desc');
        } else {
            $query->latest();
        }

        $reservations = $query->paginate(10)->appends($request->query());

        return view('reservations.index', compact('reservations'));
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
