<?php

namespace App\Http\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('role')->get();

        return view('user.index', compact('users'));
    }



    public function export()
    {
        $fileName = 'data_users.csv';

        $users = User::with('role')->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // Header kolom CSV
            fputcsv($file, ['No', 'Nama', 'Username', 'Email', 'Role']);

            $no = 1;
            foreach ($users as $u) {
                fputcsv($file, [
                    $no++,
                    $u->name,
                    $u->username,
                    $u->email,
                    $u->role->nama ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $users = \App\Models\User::with('role')->get();

        $pdf = Pdf::loadView('user.pdf', compact('users'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('data_pengguna.pdf');
    }
}
