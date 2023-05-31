<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'company_code', 'vat_code', 'firstname', 'lastname', 'email', 'phone_prefix', 'phone',
        'address', 'postcode', 'city', 'country_id'
    ];

    public function getName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    //Rework to collection maybe
    public function getAddress(): array
    {
        $address = [
            'company_name' => $this->company_name,
            'contact_person' => $this->getName(),
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'country_id' => $this->country->id,
            'country_name' => $this->country->name,
            'phone' => $this->phone_prefix . $this->phone
        ];

        return $address;
    }
}
