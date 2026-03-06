<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait LogsUserActivity
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

    public static function bootLogsUserActivity()
    {
        static::created(function ($model) {

            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->withProperties([
                    'ip' => request()->ip(),
                    'browser' => request()->userAgent()
                ])
                ->log('created');
        });

        static::updated(function ($model) {

            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->withProperties([
                    'ip' => request()->ip(),
                    'browser' => request()->userAgent()
                ])
                ->log('updated');
        });

        static::deleted(function ($model) {

            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->withProperties([
                    'ip' => request()->ip(),
                    'browser' => request()->userAgent()
                ])
                ->log('deleted');
        });
    }
}
