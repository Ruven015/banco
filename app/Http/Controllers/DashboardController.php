<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Empleado;
use App\Models\Transaccion;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        
        return view('dashboard', [
        'transacciones_por_dia' => \App\Models\Transaccion::select(
            DB::raw('DATE(fecha_hora) as fecha'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get(),
        'clientes' => \App\Models\Cliente::count(),
        'cuentas' => \App\Models\Cuenta::count(),
        'empleados' => \App\Models\Empleado::count(),

        // 💰 dinero total
        'total_dinero' => \App\Models\Cuenta::sum('saldo'),

        // ⚠️ cuentas con poco dinero
        'cuentas_bajas' => \App\Models\Cuenta::where('saldo', '<', 100)->count(),

        // 📊 últimas transacciones
        'transacciones' => \App\Models\Transaccion::latest()->take(5)->get()
    ]);
    }
}