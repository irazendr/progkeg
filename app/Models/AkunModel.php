<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Entities\User;

class AkunModel extends Model
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $returnType     = User::class;
    // protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'nama_lengkap', 'email', 'username',
    ];
    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username]',
    ];
}
