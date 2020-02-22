<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PotentialCustomer extends Model
{
    // dichiaro come 'fillabili' automaticamente i seguenti campi
    // che trovano corrispondenza nella tabella 'potential_customers'
    protected $fillable = ['name', 'email', 'subject', 'message'];

}
