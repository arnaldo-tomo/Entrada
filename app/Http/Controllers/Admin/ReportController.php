<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Card;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use App\Exports\CardsExport;

class ReportController extends Controller
{
    public function employees(Request $request)
    {
        if ($request->has('export')) {
            return Excel::download(new EmployeesExport, 'colaboradores.xlsx');
        }

        return view('admin.reports.employees');
    }

    public function cards(Request $request)
    {
        if ($request->has('export')) {
            return Excel::download(new CardsExport, 'cartoes.xlsx');
        }

        return view('admin.reports.cards');
    }
}
