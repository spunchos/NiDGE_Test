<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Exception\Exception;
use Vonage\SMS\Message\SMS;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        return view('service.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('service.create', [
            'categories' => $categories,
            'users'      => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     */
    public function store(StoreServiceRequest $request)
    {
        $category = Category::findOrFail((int) $request->input('category'));
        $service = $category->services()->create($request->except('users'));
        $service->users()->sync($request->only('users')['users']);

        try {
            $this->sendSMSNotification(
                $request->only('users')['users'],
                $request->only('title')['title']);
        } catch (ClientExceptionInterface $e) {
            dd($e->getMessage());
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return redirect(route("service.index"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     */
    public function edit(Service $service)
    {
        $service = Service::findOrFail($service->id);

        return view('service.create', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->findOrFail($service->id);
        $data = $request->validated();
        $service->update($data);

        return redirect(route('service.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     */
    public function destroy(Service $service)
    {
        Service::destroy($service->id);

        return redirect(route('service.index'));
    }

    /**
     * class for sending sms notifications
     *
     * @param $users
     * @return void
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Vonage\Client\Exception\Exception
     */
    public function sendSMSNotification($userIDs, $taskTitle): void
    {
        foreach ($userIDs as $userID){
            $basic  = new Basic("2e0348ab", "zAAohygKU8TVdGj7");
            $client = new Client($basic);
            $user = User::find($userID);
            $client->sms()->send(
                new SMS($user->phone, 'laraveltesttest', 'You were added as a performer for a task'.$taskTitle )
            );
        }
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAm2r4lh4:APA91bGIyzJirfHvtsTWAtGAOuMOJyIVgOyh6CjnG8lL1IqebDWnJnqQe8GXd7CwXScNN0lLkpbbtkTT762n_RRgjMqELWlQiPWtZykDVFHa1d5gqgNqgv196Z1H3Oq4PnLfUJKNd9kI';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}
