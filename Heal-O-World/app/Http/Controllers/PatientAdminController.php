<?php


namespace App\Http\Controllers;

use App\Models\MyOfficePatient;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAdminController extends Controller
{

    public function index()
    {
        $patients = MyOfficePatient::all(); 
        return view('admin.patient.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:15',
        ]);

        MyOfficePatient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт створений!');
    }

    public function show(MyOfficePatient $patient)
    {
        return view('admin.patient.show', compact('patient'));
    }

    public function edit(MyOfficePatient $patient)
    {
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, MyOfficePatient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:15',
        ]);

        $patient->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт оновлений!');
    }

    public function destroy(MyOfficePatient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('status', 'Пацієнт видалений!');
    }
}
