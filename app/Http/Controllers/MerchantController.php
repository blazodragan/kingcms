<?php

namespace App\Http\Controllers;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\Priority;
use App\Enums\Status;
use Spatie\Tags\Tag;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Traits\HasToken;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Casts\Json;

class MerchantController extends Controller
{
    use HasToken;
    public function index() {
        
        request()->validate([
            'per_page' => ['nullable', 'integer'],
            'status' => ['nullable', 'string'],
            'page' => ['nullable', 'integer'],
        ]);


        if (!is_null(request('per_page'))) {
            $per_page = request('per_page');
        } else {
            $per_page = 12;
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

        if (!is_null(request('has_relationships'))) {
            $has_relationships = request('has_relationships');
        } else {
            $has_relationships = null;
        }

        // Get All Status Enums and Prioerity
        $priority = Priority::cases();
        $status = Status::cases();

        $tags = Tag::WithType('ticket')->get()->pluck('name');
        // $tickets = Ticket::with('user:id,name')
        //     ->where('user_id',auth()->id())
        //     ->status(request('status'))
        //     ->priority(request('priority'))
        //     ->search(request('term'))
        //     ->tag(request('tags'))
        //     ->order(request('orderby'))
        //     ->paginate($per_page);

        try {

           
            // $accessToken = $this->getAccessToken();
            $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
            $endpoint = 'merchants.php'; // Your endpoint
            // $suiteid = auth()->user()->suiteid;
            $pages = '?limit='.$per_page.'&sort_field='.$filter_sort_field.'&sort_order='.$sort_order.'&page='.$page.'&name='.$filter_name.'&has_relationships='.$has_relationships;

            $url = $baseUrl . $endpoint .$pages ; // Construct the full URL
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

        return Inertia::render('Merchants/Show', [
            'priorityEnum' => $priority,
            'statusEnum' => $status,
            'ticketTags' => $tags,
            'queryParams' => request()->all(['status','priority','term']),
            'merchants' => $merchants
        ]);
    }
    public function photoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }

    public function store(TicketStoreRequest $request): \Illuminate\Http\RedirectResponse
    {

        $validated = $request->validated();

        $ticket = $request->user()->tickets()->create($validated);

        if (isset($request['photo_path'])) {
            $ticket->updatePhoto($request['photo_path']);

        }
        if (isset($request['tags']) and !is_null($request['tags'])) {
            $ticket->syncTagsWithType($request['tags'], 'ticket');

        }
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Ticket :name added',['name' => $ticket->name]),
            'durration' => 2000,
        ]);

    }

    public function edit(Ticket $ticket): \Inertia\Response
    {
        $priority = Priority::cases();
        $status = Status::cases();

        return Inertia::render('Tickets/EditTicket', [
            'priorityEnum' => $priority,
            'statusEnum' => $status,

            'ticket' => [
                'id' => $ticket->id,
                'uuid' => $ticket->uuid,
                'title' => $ticket->title,
                'message' => $ticket->message,
                'photo_path' => $ticket->photo_path,
                'photo_url' => $ticket->photo_url,
                'tags' => $ticket->tags()->get()->pluck('name'),
                'all_tags' => Tag::withType('ticket')->get()->pluck('name'),
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'allTicketTags' => Tag::withType('ticket')->get()->pluck('name'),
            ],
        ]);
    }

    public function check($merchant): \Inertia\Response
    {   
        $priority = Priority::cases();
        $status = Status::cases();
 
        try {

            // $accessToken = $this->getAccessToken();
            $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
            $endpoint = 'contacts.php'; // Your endpoint
            $contact = '?merchants_id='.$merchant;

            $url = $baseUrl . $endpoint .$contact ; // Construct the full URL
            $response = Http::withHeaders([
                'Authorization' => $accessToken,
            ])->get($url);
      
            if ($response->successful()) {
                $contactView = $response->json();
                // Now you can use the data from the response
            } else {
                // Handle the error
                throw new \Exception('Error retrieving data from API');
            }

        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return Inertia::render('Merchants/CheckMerchant', [
            'priorityEnum' => $priority,
            'statusEnum' => $status,
            'contactView' => $contactView,
        ]);
    }

    public function load($merchant)
    {   
        $priority = Priority::cases();
        $status = Status::cases();
 
        try {

            // $accessToken = $this->getAccessToken();
            $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
            $endpoint = 'contacts.php'; // Your endpoint
            $contact = '?merchants_id='.$merchant;

            $url = $baseUrl . $endpoint .$contact ; // Construct the full URL
            $response = Http::withHeaders([
                'Authorization' => $accessToken,
            ])->get($url);
      
            if ($response->successful()) {
                $contactView = $response->json();
                // Now you can use the data from the response
            } else {
                // Handle the error
                throw new \Exception('Error retrieving data from API');
            }

        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($contactView);
    }


    public function invoice($merchant): \Inertia\Response
    {   
        $priority = Priority::cases();
        $status = Status::cases();
 
        try {

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'X-Api-Token' => 'XCdgXHN6EfpAiaJGclBmNsm8WpUpHbsI8IHduLf04q3jcKHurp92eq1pleOo62Ik',
                'X-Requested-With' => 'XMLHttpRequest'
            ])->get('https://billing.biditi.com/api/v1/invoices?per_page=1000&include=client&client_id='.$merchant);

            
            // To get the response body as a string
            $body = $response->body();
            
            // If the response is a JSON, you can convert it to an array using:
            $data = $response->json();


            // // $accessToken = $this->getAccessToken();
            // $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            // $accessToken = env('SUITE_TOKEN'); // Get the base URL from the .env file
            // $endpoint = 'contacts.php'; // Your endpoint
            // $contact = '?merchants_id='.$ticket;

            // $url = $baseUrl . $endpoint .$contact ; // Construct the full URL

            // $response = Http::withHeaders([
            //     'Authorization' => $accessToken,
            // ])->get($url);
      
            // if ($response->successful()) {
            //     $contactView = $response->json();
            //     // Now you can use the data from the response
            // } else {
            //     // Handle the error
            //     throw new \Exception('Error retrieving data from API');
            // }

        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return Inertia::render('Merchants/InvoiceMerchant', [
            'priorityEnum' => $priority,
            'statusEnum' => $status,
            'data' => $data,
        ]);
    }

    public function pdf($ticket)
    {   

        try {
            $accessToken = $this->getAccessToken();
            $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
            $endpoint = '/legacy/Api/V8/module/Cases/'; // Your endpoint

            $url = $baseUrl . $endpoint . $ticket; // Construct the full URL
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);

            if ($response->successful()) {
                $ticketsView = $response->json();
                // Now you can use the data from the response
            } else {
                // Handle the error
                throw new \Exception('Error retrieving data from API');
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // dd($ticketsView);
        $data = ['title' => 'Welcome to HDTuto.com'];
        $pdf = PDF::loadView('pdf', $ticketsView);

        return $pdf->stream('hdtuto.pdf');
        // return view('pdf', ['name' => 'Samantha']);
    }

    public function update(TicketUpdateRequest $request, Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $ticket->update($request->validated());

        if (isset($request['photo_path'])) {
            $ticket->updatePhoto($request['photo_path']);

        }

        if (isset($request['tags']) and !is_null($request['tags'])) {
            $ticket->syncTagsWithType($request['tags'], 'ticket');

        }

        return back(303)->with('toast', [
            'type' => 'success',
            'message' => __('Title :name Updated',['name' => $ticket->title]),
            'durration' => 2000,
        ]);
    }


    public function destroy(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        #TODO "need to fix this"
        $photo_disk = isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');

        $ids = explode(",", $id);
        if (is_array($ids))
        {
            foreach ($ids as $key => $id) {
                $group_photo = Ticket::where('id', $id)->value('photo_path');
                if (!is_null($group_photo)) {
                    Storage::disk($photo_disk)->delete($group_photo);
                }
            }
            $request->user()->tickets()->whereIn('id', $ids)->delete();

        } else {

            $request->user()->tickets()->where('id', $id)->first()->delete();
        }
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Tickets Deleted'),
            'durration' => 2000,
        ]);
    }

}
