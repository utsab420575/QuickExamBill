<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportExportController extends Controller
{
    public function ImportAllTable(){
        $all_import_history = ImportHistory::latest()->get();
        return view('import_export.import_table',compact('all_import_history'));
    }

    public function ImportUserTable()
    {
        //return "Hi";
        $response = Http::withHeaders([
            'X-API-KEY' => 'EXAMBILL_98745012'
        ])->get('https://ugr.duetbd.org/api/users');

        if ($response->failed()) {
            Log::error('UGR API fetch failed.');
            return response()->json(['error' => 'Failed to fetch data from UGR API'], 500);
        }

        $users = $response->json();

        //return $users;

        DB::beginTransaction();

        try {
            $inserted = 0;
            $updated = 0;

            foreach ($users as $userData) {
                $user = User::where('email', $userData['email'])->first();

                if ($user) {
                    $user->update([
                        'name' => $userData['name'],
                        'phone' => $userData['phoneno'],
                        //'password' => $userData['password'], // already hashed
                    ]);
                    $updated++;
                    Log::info("User updated: {$user->email}");
                } else {
                    User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $userData['password'], // already hashed
                        'phone' => $userData['phoneno'],
                    ]);
                    $inserted++;
                    Log::info("User inserted: {$userData['email']}");
                }
            }

            // Record the import history
            ImportHistory::create([
                'table_name' => 'users',
                'records_inserted' => $inserted,
                'records_updated' => $updated,
                'imported_by_name' => auth()->user()->name,
                'imported_by_email' => auth()->user()->email,
                'details' => 'User data imported from UGR API'
            ]);


            DB::commit();

            Log::info("User sync completed. Inserted: $inserted, Updated: $updated");

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('User sync failed: ' . $e->getMessage());

            return response()->json(['error' => 'User sync failed.'], 500);
        }
    }
}
