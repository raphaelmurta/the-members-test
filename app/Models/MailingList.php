<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Adicionar a relação muitos-para-muitos com os usuários
    public function users()
    {
        return $this->belongsToMany(User::class, 'mailing_list_user');
    }
}
