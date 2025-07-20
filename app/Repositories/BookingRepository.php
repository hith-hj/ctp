<?php

namespace App\Repositories;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class BookingRepository
{
    public function add(Request $request)
    {
        $booking = new Booking(populateModelData($request, Booking::class));
        if (! auth()->user()->hasRole('Admin')) {
            $booking->admin_id = auth()->id();
        }
        $booking->save();
    }

    public function update(Request $request, Booking $booking)
    {
        $booking->update(populateModelData($request, Booking::class));
        $booking->save();
    }

    public function delete(Booking $booking)
    {
        $booking->delete();
    }

    public function getBookingsDataTable(Request $request): LengthAwarePaginator
    {

        $bookings = Booking::query();

        if (auth()->user()->hasRole('service-provider')) {
            $bookings->where('admin_id', auth()->id());
        }

        if ($request->has('query')) {
            if (isset($request->get('query')['status']) != null) {
                $bookings->where('status', $request->get('query')['status']);
            }

            if (isset($request->get('query')['admin_id']) != null) {
                $bookings->where('admin_id', $request->get('query')['admin_id']);
            }

            if (isset($request->get('query')['service_id']) != null) {
                $bookings->where('service_id', $request->get('query')['service_id']);
            }

            if (isset($request->get('query')['phone_number']) != null) {
                $bookings->where('phone_number', $request->get('query')['phone_number']);
            }

            if (isset($request->get('query')['from_date']) != null) {
                $bookings->where('date', '>=', $request->get('query')['from_date']);
            }

            if (isset($request->get('query')['to_date']) != null) {
                $bookings->where('date', '<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());
            }

            if (isset($request->get('query')['search']) != null) {
                $tokens = convertToSeparatedTokens($request->get('query')['search']);
                $bookings->where('code', 'LIKE', "%{$request->get('query')['search']}%");

                $bookings->orWhereHas('client', function ($query) use ($tokens) {
                    $query->whereRaw('MATCH(first_name, last_name, email, phone_number) AGAINST(? IN BOOLEAN MODE)', $tokens);
                });
                $bookings->orWhereHas('provider', function ($query) use ($tokens) {
                    $query->whereRaw('MATCH(name, username, email) AGAINST(? IN BOOLEAN MODE)', $tokens);
                });
            }
        }

        if ($request->has('sort')) {
            $field = $request->get('sort')['field'];
            if (! in_array($field, app(Booking::class)->getFillable())) {
                $field = 'id';
            }
            $bookings = $bookings->orderBy($field, $request->get('sort')['sort'] ?? 'asc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        } else {
            $bookings = $bookings->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        }

        return $bookings;

    }
}
