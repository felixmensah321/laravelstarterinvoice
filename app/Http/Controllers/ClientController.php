<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = $request->user()->clients()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('company', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('invoices')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $data = $this->prepareRecurringData($request->validated());

        $request->user()->clients()->create($data);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $this->authorizeClient($client);

        $client->load(['invoices' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $this->authorizeClient($client);

        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorizeClient($client);

        $data = $this->prepareRecurringData($request->validated());

        $client->update($data);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->authorizeClient($client);

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    protected function authorizeClient(Client $client): void
    {
        abort_unless($client->user_id === auth()->id(), 403);
    }

    protected function prepareRecurringData(array $data): array
    {
        $frequencyMonths = [
            'monthly' => 1,
            'quarterly' => 3,
            'semi_annual' => 6,
            'annual' => 12,
        ];

        if (!empty($data['recurring_enabled']) && !empty($data['recurring_frequency']) && !empty($data['business_start_date'])) {
            $data['recurring_frequency_months'] = $frequencyMonths[$data['recurring_frequency']];
            $data['next_invoice_date'] = $this->calculateNextInvoiceDate(
                Carbon::parse($data['business_start_date']),
                $data['recurring_frequency_months']
            );
        } else {
            $data['recurring_enabled'] = false;
            $data['recurring_frequency'] = null;
            $data['recurring_frequency_months'] = null;
            $data['next_invoice_date'] = null;
        }

        return $data;
    }

    protected function calculateNextInvoiceDate(Carbon $startDate, int $frequencyMonths): Carbon
    {
        $today = Carbon::today();
        $nextDate = $startDate->copy();

        while ($nextDate->lt($today)) {
            $nextDate->addMonths($frequencyMonths);
        }

        return $nextDate;
    }
}
