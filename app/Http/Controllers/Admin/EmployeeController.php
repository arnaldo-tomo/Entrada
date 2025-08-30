<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identification_number', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $employees = $query->withCount('cards')->latest()->paginate(15);

        $departments = Employee::distinct()->pluck('department')->filter();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function show(Employee $employee)
    {
        $employee->load(['cards.cardTemplate']);
        return view('admin.employees.show', compact('employee'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification_number' => 'required|string|unique:employees,identification_number',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        Employee::create($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Colaborador criado com sucesso!');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification_number' => 'required|string|unique:employees,identification_number,' . $employee->id,
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Colaborador removido com sucesso!');
    }
}
