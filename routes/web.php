<?php

use App\Http\Controllers\MualafSertifikatController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/staf', function () {
    if (!auth()->check()) {
        return redirect('/staf/login');
    }

    $user = auth()->user();

    if ($user->role === 'superadmin') {
        return redirect('/staf/admin/pusat');
    }

    if ($user->role === 'staf' && is_null($user->tenant_id)) {
        return redirect('/staf/pusat');
    }

    if ($user->role === 'admin' && $user->tenant) {
        return redirect('/staf/admin/' . $user->tenant->slug);
    }

    if ($user->role === 'dai' && $user->tenant) {
        return redirect('/staf/dai/' . $user->tenant->slug);
    }

    if ($user->role === 'staf' && $user->tenant) {
        return redirect('/staf/' . $user->tenant->slug);
    }

    return redirect('/staf/login');
});

Route::get('/login', function () {
    return redirect('/');
})->name('login');

use App\Models\Mualaf;

Route::get('/mualaf/{mualaf}/cetak-sertifikat', function (Mualaf $mualaf) {
    if ($mualaf->status !== 'lulus') {
        abort(403, 'Sertifikat hanya dapat dicetak untuk mualaf yang telah lulus.');
    }

    return view('sertifikat-mualaf', compact('mualaf'));
})->name('mualaf.cetak-sertifikat')->middleware(['auth']);