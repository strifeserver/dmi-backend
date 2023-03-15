<?php

namespace App\Listeners;

use App\Audit;
use Illuminate\Support\Facades\Auth;

class AuditTrailListener
{
    public function handle($event)
    {
        $user = Auth::user();
        $old_values = $event->getOriginal();
        $new_values = $event->getAttributes();

        $audit_res = Audit::create([
            'event' => $event->wasRecentlyCreated ? 'created' : 'updated',
            'auditable_type' => get_class($event),
            'auditable_id' => $event->id,
            'old_values' => json_encode($old_values),
            'new_values' => json_encode($new_values),
            'user_id' => $user ? $user->id : null,
        ]);

    }
}