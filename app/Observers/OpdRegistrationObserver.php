<?php

namespace App\Observers;

use App\Models\Opd;

class OpdRegistrationObserver
{
    //
    public function creating(Opd $opd)
    {
        // The ID is not available here yet.
    }

    public function created(Opd $opd)
    {
        // Update the user_id once the ID is available.
        $opd->user_id = 'O-' . str_pad($opd->id, 5, '0', STR_PAD_LEFT);
        $opd->saveQuietly(); // Avoid infinite loop by saving without triggering events.
    }
}
