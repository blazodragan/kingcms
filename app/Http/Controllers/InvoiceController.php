<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        request()->validate([
            'per_page' => ['nullable', 'integer'],
            'status' => ['nullable', 'string'],
            'page' => ['nullable', 'integer'],
        ]);


        if (!is_null(request('per_page'))) {
            $per_page = request('per_page');
        } else {
            $per_page = 48;
        }

        if (!is_null(request('page'))) {
            $page = request('page');
        } else {
            $page = 1;
        }

        if (!is_null(request('sort_order'))) {
            $sort_order = 'DESC';
        } else {
            $sort_order = 'ASC';
        }

        if (!is_null(request('sort_field'))) {
            $filter_sort_field = request('sort_field');
        } else {
            $filter_sort_field = 'id';
        }

        if (!is_null(request('term'))) {
            $filter_name = request('term');
        } else {
            $filter_name = null;
        }
        if (!is_null(request('page'))) {
            $filter_page = request('page');
        } else {
            $filter_page = null;
        }

        if (!is_null(request('product_key'))) {
            $replace = preg_replace("/^Банкарски ПОС терминал /", "", request('product_key'));
            $product_key = '&filter=' . $replace;
        } else {
            $product_key = null;
        }

        // Collect Product_keys that you have in invoice ninja
        try {

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Token' => 'XCdgXHN6EfpAiaJGclBmNsm8WpUpHbsI8IHduLf04q3jcKHurp92eq1pleOo62Ik',
                'X-Requested-With' => 'XMLHttpRequest'
            ])->get('https://billing.biditi.com/api/v1/products?per_page=1000');


            // If the response is a JSON, you can convert it to an array using:
            $product_keys = $response->json();
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // display all invoices for a particular product_key
        try {

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Token' => 'XCdgXHN6EfpAiaJGclBmNsm8WpUpHbsI8IHduLf04q3jcKHurp92eq1pleOo62Ik',
                'X-Requested-With' => 'XMLHttpRequest'
            ])->get('https://billing.biditi.com/api/v1/invoices?per_page=' . $per_page . '&include=client&page=' . $filter_page . $product_key);

            // If the response is a JSON, you can convert it to an array using:
            $data = $response->json();
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // extract the client_ids from invoice ninja so we can match them to the MERCHANT_FINANCE_CODE from CRM . 
        $clientIds = array_column($data['data'], 'client_id');

        // collect all merchant from crm 
        try {
            // $accessToken = $this->getAccessToken();
            $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
            $endpoint = 'merchants.php'; // Your endpoint
            // $suiteid = auth()->user()->suiteid;
            $pages = '?limit=1000&&has_relationships=true';

            $url = $baseUrl . $endpoint . $pages; // Construct the full URL
            $response = Http::withHeaders([
                'Authorization' => $accessToken,
            ])->get($url);

            if ($response->successful()) {
                $merchants = $response->json();
                // Now you can use the data from the response
            } else {
                // Handle the error
                throw new \Exception('Error retrieving data from API');
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }


        // Filter the second array to get entries where MERCHANT_FINANCE_CODE is not in clientIds
        $resultArray = array_filter($merchants['data'], function ($item) use ($clientIds) {
            return !in_array($item["merchant_finance_code"], $clientIds);
        });

        return Inertia::render('Invoices/Show', [
            'data' => $data,
            'queryParams' => request()->all(['status', 'priority', 'term']),
            'product_keys' => $product_keys,
            'makeInvoice' => $resultArray,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (is_array($request['MerchantBeingInvoiced'])) {

            foreach ($request['MerchantBeingInvoiced'] as $key => $id) {

                try {
                    // $accessToken = $this->getAccessToken();
                    $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
                    $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
                    $endpoint = 'contacts.php'; // Your endpoint
                    $contact = '?merchants_id=' . $id;

                    $url = $baseUrl . $endpoint . $contact; // Construct the full URL
                    $response = Http::withHeaders([
                        'Authorization' => $accessToken,
                    ])->get($url);

                    if ($response->successful()) {
                        $merchantInfo = $response->json();
                        // Now you can use the data from the response
                    } else {
                        // Handle the error
                        throw new \Exception('Error retrieving data from API');
                    }
                } catch (\Exception $e) {
                    // Handle the exception
                    return response()->json(['error' => $e->getMessage()], 500);
                }

                // count the toal terminals so we can make the invoice from the product key 
                $totalTerminals = 0;
                $result = [];

                // this will make an array if we want to print the terminals in the footer 
                foreach ($merchantInfo['contacts'] as $contact) {
                    $terminals = $contact['terminals'];
                    $totalTerminals += count($terminals);

                    foreach ($terminals as $terminal) {
                        $result[$contact['name']][] = $terminal['name'];
                    }
                }

                // data that will be needed for exsecuting the api call for making the invoice
                $url = 'https://billing.biditi.com/api/v1/invoices';
                $token = 'XCdgXHN6EfpAiaJGclBmNsm8WpUpHbsI8IHduLf04q3jcKHurp92eq1pleOo62Ik';

                // id that from invoice ninja for the merchant
                $merchant_id = $merchantInfo['merchant'][0]['merchant_finance_code'];

                // bank account for the merchant
                $merchant_nlb = $merchantInfo['merchant'][0]['merchant_bank_account_nlb'];

                // product key name
                $product_key = $request['product_key'];
                $due_date = Carbon::now()->addDays(8)->toDateString();
                // Invoice data
                $data = [
                    'client_id' => $merchant_id, // Replace with the client ID
                    'custom_value2' => $merchant_nlb,
                    'due_date' => $due_date,
                    'tax_name1' => "ДДВ 18%",
                    'tax_rate1' => 18,
                    'terms' => "8 дена",
                    'custom_value1' => "$product_key",
                    'line_items' => [
                        [
                            'product_key' => "$product_key",
                            'quantity' => $totalTerminals,
                            'notes' => "Месечен надоместок за користење на $product_key",
                            'cost' => 862,
                        ]
                    ]
                ];

                // Post request for making the invoice
                try {
                    // Make the POST request
                    $response = Http::withHeaders([
                        'X-Api-Token' => $token,
                        'Content-Type' => 'application/json'
                    ])->post($url, $data);

                    // Save the response to an array
                    $responseArray = $response->json();
                } catch (\Exception $e) {
                    // Handle the exception
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
        } else {

        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Invoices Build'),
            'durration' => 2000,
            'responseArray' => $responseArray,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
