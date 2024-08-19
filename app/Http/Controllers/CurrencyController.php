<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Rates\View;

class CurrencyController extends Controller
{
    private $view;
    public function __construct()
    {
        $this->view = new View();
    }

    public function index(Request $request)
    {
        $base = $request->has('base') ? $request->base : 'USD';
        $target = $request->has('target') && strlen($request->target) > 0 ? $request->target : '';
        $date = $request->date && strlen($request->date) > 0 ? $request->date : '';

        $rates = $this->view->filter($base, $target, $date);
        $data = [
            'rates' => $rates,
            'filter' => ['base' => $base, 'target' => $target, 'date' => $date]
        ];

        return view('index', ['data' => json_decode(json_encode($data))]);
    }
}