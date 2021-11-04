<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function contactDosen($id)
    {
        $data = Dosen::find($id);
        return response()->json([
            'message' => 'berhasil',
            'data' => $data
        ], 200);
    }
}
