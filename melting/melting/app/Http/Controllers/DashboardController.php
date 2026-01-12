<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\FollowUps;
use App\Models\Producto;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tasksInProgress = Task::where('user_id', $user->id)->where('status', 'en progreso')->get();
        $tasksCompleted = Task::where('user_id', $user->id)->where('status', 'completada')->get();
        $tasksPendings = Task::where('user_id', $user->id)->where('status', 'pendiente')->get();
        $clients = Client::all();
        $follows = FollowUps::whereDate('follow_up_date', today())->get();
        $compras = Compra::all();

        // ========== DATOS DEL MES EN CURSO ==========
        
        // Cantidad de compras del mes
        $comprasDelMes = Compra::whereYear('fecha', now()->year)
            ->whereMonth('fecha', now()->month)
            ->count();

        // Suma total de kilos del mes (suma de todas las cantidades de los items del mes)
        $kilosDelMes = CompraItem::whereHas('compra', function ($query) {
            $query->whereYear('fecha', now()->year)
                ->whereMonth('fecha', now()->month);
        })->sum('cantidad');

        // Dinero acumulado del mes (suma de subtotales o cantidad * precio)
        $dineroDelMes = CompraItem::whereHas('compra', function ($query) {
            $query->whereYear('fecha', now()->year)
                ->whereMonth('fecha', now()->month);
        })->sum(DB::raw('cantidad * precio'));

        // ========== DATOS TOTALES ACUMULADOS (SIN IMPORTAR MES) ==========
        
        // Total de compras acumuladas
        $totalComprasAcumuladas = Compra::count();

        // Total de kilos acumulados
        $totalKilosAcumulados = CompraItem::sum('cantidad');

        // Total de dinero acumulado
        $totalDineroAcumulado = CompraItem::sum(DB::raw('cantidad * precio'));

        // ========== STOCK ACUMULADO POR BODEGA/SUCURSAL ==========
        $stockPorBodega = Compra::groupBy('bodega')
            ->selectRaw('bodega, SUM(compra_items.cantidad) as total_kilos')
            ->leftJoin('compra_items', 'compras.id', '=', 'compra_items.compra_id')
            ->get();

        // Preparar datos para el gráfico
        $bodegas = [];
        $kilosPorBodega = [];
        foreach ($stockPorBodega as $stock) {
            $bodegas[] = ucfirst($stock->bodega);
            $kilosPorBodega[] = (int)$stock->total_kilos;
        }

        // ========== ESTADÍSTICAS RÁPIDAS ==========
        $promedioCompra = $totalComprasAcumuladas > 0 ? round($totalDineroAcumulado / $totalComprasAcumuladas, 2) : 0;
        $costoPorKilo = $totalKilosAcumulados > 0 ? round($totalDineroAcumulado / $totalKilosAcumulados, 2) : 0;
        $promedioKilosCompra = $totalComprasAcumuladas > 0 ? round($totalKilosAcumulados / $totalComprasAcumuladas, 2) : 0;

        // ========== TOP 5 MATERIALES MÁS COMPRADOS ==========
        $topMateriales = CompraItem::select('material', DB::raw('SUM(cantidad) as total_cantidad'), DB::raw('COUNT(*) as veces_comprado'))
            ->groupBy('material')
            ->orderBy('total_cantidad', 'DESC')
            ->limit(5)
            ->get();

        // ========== ÚLTIMAS 10 COMPRAS ==========
        $ultimasCompras = Compra::with('cliente')
            ->orderBy('created_at', 'DESC')
            ->limit(7)
            ->get();

        // ========== IVA POR BODEGA DEL MES EN CURSO ==========
        // IVA = 19% del valor total. Como el valor ya incluye IVA, sacamos el porcentaje
        $ivaTalcaMes = CompraItem::whereHas('compra', function ($query) {
            $query->whereYear('fecha', now()->year)
                ->whereMonth('fecha', now()->month)
                ->where('bodega', 'talca');
        })->sum(DB::raw('cantidad * precio * 0.19 / 1.19'));

        $ivaChillanMes = CompraItem::whereHas('compra', function ($query) {
            $query->whereYear('fecha', now()->year)
                ->whereMonth('fecha', now()->month)
                ->where('bodega', 'chillan');
        })->sum(DB::raw('cantidad * precio * 0.19 / 1.19'));

        // ========== IVA POR BODEGA ACUMULADO ==========
        $ivaTalcaTotal = CompraItem::whereHas('compra', function ($query) {
            $query->where('bodega', 'talca');
        })->sum(DB::raw('cantidad * precio * 0.19 / 1.19'));

        $ivaChillanTotal = CompraItem::whereHas('compra', function ($query) {
            $query->where('bodega', 'chillan');
        })->sum(DB::raw('cantidad * precio * 0.19 / 1.19'));

        return view('dashboard', compact(
            'tasksPendings',
            'tasksInProgress',
            'tasksCompleted',
            'clients',
            'follows',
            'compras',
            'comprasDelMes',
            'kilosDelMes',
            'dineroDelMes',
            'totalComprasAcumuladas',
            'totalKilosAcumulados',
            'totalDineroAcumulado',
            'bodegas',
            'kilosPorBodega',
            'promedioCompra',
            'costoPorKilo',
            'promedioKilosCompra',
            'topMateriales',
            'ultimasCompras',
            'ivaTalcaMes',
            'ivaChillanMes',
            'ivaTalcaTotal',
            'ivaChillanTotal'
        ));
    }
}
