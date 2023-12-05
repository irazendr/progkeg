<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Entities\User;

class GroupAkunModel extends Model
{
    protected $table            = 'auth_groups_users';
    protected $primaryKey       = 'user_id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['group_id'];
}