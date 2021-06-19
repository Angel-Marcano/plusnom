<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $request->perPage;
        $query = Login::latest();

        if ($request->has('filter')) {
            $filters = $request->filter;

            if (array_key_exists('role', $filters)) {
                $query->whereHas('user', function ($q) use ($filters) {
                    $q->byRole($filters['role']);
                });
            }
            if (array_key_exists('active', $filters)) {
                $query->where('active', '=', $filters['active']);
            }
            if (array_key_exists('user_id', $filters)) {
                $query->where('user_id', '=', $filters['user_id']);
            }
            if (array_key_exists('gt_date', $filters)) {
                $query->whereDate('created_at', '>=', $filters['gt_date']);
            }
        }

        return $query->paginate($results);
    }
}
