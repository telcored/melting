<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\CompraItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('cliente')->orderBy('id', 'desc')->paginate(7);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $clientes = Client::where('active', 1)->get();
        $productos = Producto::all();

        return view('compras.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|unique:compras,folio',
            'client_id' => 'required',
            'fecha' => 'required|date',
            'bodega' => 'required',
            'producto_id.*' => 'required',
            'cantidad.*' => 'required|numeric|min:0.1',
            'precio.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // 1) crear compra
            $compra = Compra::create([
                'folio' => $request->folio,
                'client_id' => $request->client_id,
                'fecha' => $request->fecha,
                'bodega' => $request->bodega,
                'factura' => $request->factura,
                'declaracion' => $request->declaracion,
            ]);

            // 2) guardar items
            foreach ($request->producto_id as $i => $productoId) {

                $producto = Producto::find($productoId);

                $cantidad = $request->cantidad[$i];
                $precio   = $request->precio[$i];
                $subtotal = $cantidad * $precio;

                CompraItem::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $productoId,
                    'material' => $producto->material,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $subtotal
                ]);

                // 3) actualizar stock del producto
                if ($producto->bodega != $request->bodega) {
                    // si el producto cambia de bodega lo movemos
                    $producto->bodega = $request->bodega;
                }

                $producto->cantidad += $cantidad;
                $producto->save();
            }

            DB::commit();

            return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $compra = Compra::with(['cliente', 'items.producto'])->findOrFail($id);
        return view('compras.show', compact('compra'));
    }


    public function edit($id)
    {
        $compra = Compra::with(['cliente', 'items.producto'])->findOrFail($id);
        $clientes = Client::where('active', 1)->get();
        $productos = Producto::all();

        return view('compras.edit', compact('compra', 'clientes', 'productos'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'folio' => 'required|string',
            'bodega' => 'required|in:talca,chillan',
            'cliente_id' => 'required|exists:clients,id',
            'fecha' => 'required|date',
            'material.*' => 'required|string',
            'producto_id.*' => 'nullable|exists:productos,id',
            'cantidad.*' => 'required|numeric|min:0.1',
            'precio.*' => 'required|numeric|min:0',
        ]);

        $compra = Compra::findOrFail($id);

        // Actualiza datos base
        $compra->update([
            'folio' => $request->folio,
            'bodega' => $request->bodega,
            'client_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'factura' => $request->factura,
            'declaracion' => $request->declaracion,
        ]);

        // Elimina items antiguos
        $compra->items()->delete();

        // Crea items nuevos
        foreach ($request->material as $i => $mat) {
            $cantidad = $request->cantidad[$i];
            $precio = $request->precio[$i];
            $subtotal = $cantidad * $precio;

            $compra->items()->create([
                'material' => $mat,
                'producto_id' => $request->producto_id[$i] ?? null,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal,
            ]);

            // OPCIONAL: actualizar stock de productos
            if (!empty($request->producto_id[$i])) {
                $producto = Producto::find($request->producto_id[$i]);
                if ($producto) {
                    $producto->cantidad += $cantidad; // o lógica según bodega
                    $producto->save();
                }
            }
        }

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra actualizada correctamente.');
    }


    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada.');
    }

    public function generatePdf($id)
    {
        $compra = Compra::with(['cliente', 'items'])->findOrFail($id);
        $total = $compra->items->sum('subtotal');

        $pdf = Pdf::loadView('pdf.compra', compact('compra', 'total'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Acta_Compra_{$compra->folio}.pdf");
    }
}
