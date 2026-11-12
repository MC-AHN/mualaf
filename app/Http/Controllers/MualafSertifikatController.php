<?php

namespace App\Http\Controllers;

use App\Models\Mualaf;

use Illuminate\Http\Request;

class MualafSertifikatController extends Controller
{
    public function __invoke(Mualaf $mualaf)
    {
        if ($mualaf->status !== 'lulus') {
            abort(403, 'Sertifikat hanya dapat dicetak untuk mualaf yang telah LULUS');
        }

        $mualaf->load('tenant');

        return view('sertifikat-mualaf', compact('mualaf'));
    }
}
