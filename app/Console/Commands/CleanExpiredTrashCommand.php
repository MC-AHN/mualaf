<?php

namespace App\Console\Commands;

use App\Models\BimbinganProgress;
use App\Models\Mualaf;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:clean-expired-trash-command')]
#[Description('Hapus permanen data trash yang sudah lebih dari 30 hari')]
class CleanExpiredTrashCommand extends Command
{    
    public function handle()
    {
        $cutoffDate = now()->subDay(30);

        $deletedMualafs = Mualaf::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->forceDelete();
        $deleteJurnals = BimbinganProgress::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->forceDelete();

        $this->info("Berhasil membersihkan data terhapus permanen.");
    }
}
