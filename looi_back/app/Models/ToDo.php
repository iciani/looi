<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToDo extends Model
{
    use HasFactory;

    protected $table = 'to_do';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'state',
        'thumbnail',
        'committed_due_date',
        'priority'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $state = $request->query('state', null);
        if (!is_null($state)) {
            $query = $query->where('state', $state);
        }

        $committedDueDate = $request->query('committed_due_date', null);
        if (!is_null($committedDueDate)) {
            $query = $query->where('committed_due_date', $committedDueDate);
        }

        $sort = $request->query('sort', null);
        if (!is_null($sort)) {
            $query = $query->orderBy($sort, 'DESC');
        }
        return $query;
    }
}
