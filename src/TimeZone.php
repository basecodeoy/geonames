<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class TimeZone extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return GeoNames::getTimeZoneTableName();
    }
}
