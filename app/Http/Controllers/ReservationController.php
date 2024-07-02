<?php

namespace App\Http\Controllers;

use App\Models\Tva;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Mail\ReservationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Reservation\ReservationResource;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $hotel_id = request()->input('hotel_id');
        $reservations = $hotel_id ? Reservation::where('hotel_id', $hotel_id)->get() : Reservation::all();
        return response()->json([
            'message' => 'Liste des réservations récupérée avec succès',
            'data' => ReservationResource::collection($reservations)
        ], 200);
    }

    public function countByStatus(Request $request) : JsonResponse
    {
        $status = request()->input('statut');
        $hotel_id = request()->input('hotel_id');
        // dd($status, $hotel_id);


        if ($status && $hotel_id) {
            $count = Reservation::where('hotel_id', $hotel_id)
                                ->where('statut', $status)
                                ->count();

            return response()->json([
                'message' => 'Nombre de réservations récupéré avec succès',
                'count' => $count
            ], 200);
        }

        return response()->json([
            'message' => 'Les paramètres statut et hotel_id sont requis',
        ], 400);
    }

    public function hotelByStatutAndHotel(Request $request): JsonResponse
    {
        $hotel_id = $request->query('hotel_id');
        $statut = $request->query('statut');

        $query = Reservation::query();

        if ($hotel_id) {
            $query->where('hotel_id', $hotel_id);
        }

        if ($statut) {
            $query->where('statut', $statut);
        }

        $reservations = $query->get();
        // dd($reservations);

        return response()->json([
            'message' => 'Liste des réservations récupérée avec succès',
            'data' => ReservationResource::collection($reservations)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Set agent_reception_id based on type
        if ($request->filled('type') && ($request->type === 'appel' || $request->type === 'presentiel')) {
            $data['agent_reception_id'] = auth()->user()->id ?? 13;
        }

        // Set hotel_id
        $data['hotel_id'] = request()->input('hotel_id', auth()->user()->hotel->id ?? User::findOrFail(2)->hotel->id);

        // Get a random user id from the same hotel for charger_suivie_id
        $data['charger_suivie_id'] = User::inRandomOrder()->where('hotel_id', $data['hotel_id'])->value('id');

        // Separate chambres data
        $chambres = $data['chambres'];
        unset($data['chambres']);

        // Use transaction to ensure all or nothing
        try {
            DB::beginTransaction();

            // Create the reservation
            $reservation = Reservation::create($data);

            // Attach chambres to the reservation
            $reservation->chambres()->attach($chambres);

            // Update chambre availability
            foreach ($reservation->chambres as $chambre) {
                $chambre->update(['disponibilite' => false]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erreur lors de la création de la réservation'], 500);
        }

        // Generate PDF
        $pdfData = [
            'title' => 'Facture Pro Forma',
            'date' => date('d/m/yyyy'),
            'reservation' => $reservation,
            'tva' => Tva::first()->taux
        ];

        $pdfPath = $reservation->fatureProFormaPath() . '.pdf';
        $pdf = Pdf::loadView('facture/facture_proforma', $pdfData);
        $pdf->save($pdfPath);

        // Send reservation email
        Mail::to($reservation->client)->send(new ReservationMail($reservation));


        // Delete the PDF file
        // Storage::disk('public')->delete('/'.$pdfPath);
        if (File::exists(public_path() . '/' . $pdfPath)) {
            File::delete(public_path() . '/' . $pdfPath);
        }


        // Return response
        return response()->json([
            'message' => 'Réservation créée avec succès',
            'data' => new ReservationResource($reservation)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json([
            'message' => 'Réservation récupérée avec succès',
            'data' => new ReservationResource($reservation)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        // Méthode vide, car normalement, cette action est gérée par le front-end
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $data = $request->validated();

        // dd($data);

        if (isset($data['chambres'])) {
            $otherData['chambres'] = $data['chambres'];
            unset($data['chambres']);
        }

        $reservation->update($data);

        if (isset($otherData['chambres']))
            $reservation->chambres()->sync($otherData['chambres']);

        return response()->json([
            'message' => 'Réservation mise à jour avec succès',
            'data' => new ReservationResource($reservation)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();
        $reservation->update([
            'supprimer_par_id' => auth()->user()->id ?? 2
        ]);

        return response()->json([
            'message' => 'Réservation supprimée avec succès'
        ], 200);
    }
}